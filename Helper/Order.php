<?php

namespace Springbot\Main\Helper;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\AlreadyExistsException;

class Order extends \Magento\Framework\App\Helper\AbstractHelper
{
    private $storeId;
    private $productRepository;
    private $customerRepository;
    private $storeRepository;
    private $regionHelper;
    private $region;
    private $cartRepository;
    private $cartManagement;
    private $invoiceService;
    private $transaction;

    private $customerData;
    private $addressData;
    private $quoteData;
    private $marketplaces;

    /**
     * @param \Magento\Framework\App\Helper\Context                    $context
     * @param \Magento\Catalog\Model\ProductRepository                 $productRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Store\Model\StoreRepository                     $storeRepository
     * @param \Magento\Directory\Helper\Data                           $regionHelper
     * @param \Magento\Directory\Model\Region                          $region
     * @param \Magento\Quote\Api\CartRepositoryInterface               $cartRepository
     * @param \Magento\Quote\Api\CartManagementInterface               $cartManagement
     * @param \Magento\Sales\Model\Service\InvoiceService              $InvoiceService
     * @param \Magento\Framework\DB\Transaction                        $Transaction
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreRepository $storeRepository,
        \Magento\Directory\Helper\Data $regionHelper,
        \Magento\Directory\Model\Region $region,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        \Magento\Quote\Api\CartManagementInterface $cartManagement,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\DB\Transaction $transaction
    ) {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->storeRepository = $storeRepository;
        $this->regionHelper = $regionHelper;
        $this->region = $region;
        $this->cartRepository = $cartRepository;
        $this->cartManagement = $cartManagement;
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        parent::__construct($context);
    }

    /**
     * @param int                                                         $storeId
     * @param \Magento\Customer\Api\Data\CustomerInterface                $customerData
     * @param \Magento\Customer\Api\Data\AddressInterface                 $addressData
     * @param \Magento\Quote\Api\Data\CartInterface                       $quoteData
     * @param \Magento\Quote\Api\Data\CartItemInterface[]                 $itemsData
     * @param \Springbot\Main\Api\Entity\Data\Order\MarketplacesInterface $marketplacesData
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface
     */
    public function buildOrder($storeId, $customerData, $addressData, $quoteData, $itemsData, $marketplacesData)
    {
        $this->storeId = $storeId;
        $this->customerData = $customerData;
        $this->addressData = $addressData;
        $this->quoteData = $quoteData;
        $this->quoteItemsData = $itemsData;
        $this->marketplaces = $marketplacesData;

        if ($this->findOrCreateCustomer()) {

            if ($quote = $this->buildQuote()) {

                $order = $this->cartManagement->submit($quote);

                $tax = $this->marketplaces->getTax();

                $order->setTaxAmount($order->getTaxAmount() + $tax);
                $order->setBaseTaxAmount($order->getBaseTaxAmount() + $tax);
                $order->setGrandTotal($order->getGrandTotal() + $tax);
                $order->setBaseGrandTotal($order->getBaseGrandTotal() + $tax);

                $order->save();

                if ($order->canInvoice()) {

                    $invoice = $this->invoiceService->prepareInvoice($order);
                    $invoice->register();
                    $transactionSave = $this->transaction->addObject(
                        $invoice
                    )->addObject(
                        $invoice->getOrder()
                    );
                    $transactionSave->save();

                    $order->setState("processing")->setStatus("processing");
                    $order->save();
                }
            }
        }
        return $order;
    }

    private function buildQuote()
    {
        $this->quoteData->assignCustomer($this->customer);

        $quote = $this->quoteData
            ->setStoreId($this->getStore()->getId())
            ->save();

        foreach ($this->quoteItemsData as $itemData) {

            // Get product model by sku
            $product = $this->productRepository->get($itemData->getSku());

            $product->setPrice($itemData->getPrice())   // Set price
                    ->setTaxClassId(0)                  // Set tax class 0
                    ->save();                           // Save

            $quote->addProduct($product, $itemData->getQty());
        }

        $shippingAddress = $quote->getShippingAddress();

        $shippingAddress->setQuote($quote)
                        ->importCustomerAddressData($this->customer->getAddresses()[0])
                        ->setShippingMethod('sbmarketplaces_sbmarketplaces')
                        ->setCollectShippingRates(true)
                        ->save();

        $rates = $shippingAddress->collectShippingRates()->getGroupedAllShippingRates();

        foreach ($rates as $carrier) {
            foreach ($carrier as $rate) {
                $rate->setPrice($this->marketplaces->getShippingTotal());
                $rate->save();
            }
        }

        $quote->setShippingAddress($shippingAddress);
        $quote->setPaymentMethod('sbmarketplaces_sbmarketplaces');
        $this->cartRepository->save($quote);

        $quote->getPayment()->importData(['method' => 'sbmarketplaces']);
        $quote->setTotalsCollectedFlag(true);
        $quote->collectTotals();
        $quote->save();

        return $quote;
    }

    private function getStore()
    {
        if (!isset($this->store)) {
            $this->store = $this->storeRepository->getById($this->customerData->getStoreId());
        }
        return $this->store;
    }

    private function getAddresses()
    {
        $this->address = $this->addressData
            ->setRegionId($this->getRegionId())
            ->setIsDefaultBilling(true)
            ->setIsDefaultShipping(true);

        return [ $this->address ];
    }

    private function getRegionId()
    {
        $regionName = $this->marketplaces->getRegion();

        if ($this->regionHelper->isRegionRequired($this->addressData->getCountryId())) {
            $this->region->loadByName($regionName, $this->addressData->getCountryId());
            $this->region->loadByCode($regionName, $this->addressData->getCountryId());
        }
        return $this->region->getRegionId();
    }

    private function findOrCreateCustomer()
    {
        if (!isset($this->customer)) {
            try {
                $this->customerData
                    ->setWebsiteId($this->getStore()->getWebsiteId())
                    ->setAddresses($this->getAddresses());

                $this->customer = $this->customerRepository->save($this->customerData);
            } catch (AlreadyExistsException $e) {
                // Customer has already been created with email
                $this->customer = $this->customerRepository->get($this->customerData->getEmail(), $this->getStore()->getWebsiteId());
            }
        }
        return $this->customer;
    }
}
