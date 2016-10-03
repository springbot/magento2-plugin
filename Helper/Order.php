<?php

namespace Springbot\Main\Helper;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\AlreadyExistsException;

class Order extends \Magento\Framework\App\Helper\AbstractHelper
{
    private $storeId;
    private $customerData;
    private $addressData;
    private $quoteData;
    private $itemsData;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory
     * @param \Magento\Customer\Model\ResourceModel\AddressRepository $addressRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Customer\Model\StoreRepository $storeRepository
     * @param \Magento\Directory\Helper\Data $regionHelper
     * @param \Magento\Directory\Model\Region $region
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Quote\Api\Data\CartInterfaceFactory $cartFactory
     * @param \Magento\Quote\Model\Quote\Item\Repository $quoteItemRepository
     * @param \Magento\Framework\Logger\Monolog $logger
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\ResourceModel\AddressRepository $addressRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreRepository $storeRepository,
        \Magento\Directory\Helper\Data $regionHelper,
        \Magento\Directory\Model\Region $region,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Quote\Api\Data\CartInterfaceFactory $cartFactory,
        \Magento\Quote\Model\Quote\Item\Repository $quoteItemRepository,
        \Magento\Framework\Logger\Monolog $logger
    ) {
        $this->objectManager = $objectManager;
        $this->productRepository = $productRepository;
        $this->customerFactory = $customerFactory;
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
        $this->storeRepository = $storeRepository;
        $this->regionHelper = $regionHelper;
        $this->region = $region;
        $this->quoteRepository = $quoteRepository;
        $this->cartFactory = $cartFactory;
        $this->quoteItemRepository = $quoteItemRepository;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @param int $storeId
     * @param \Magento\Customer\Api\Data\CustomerInterface $customerData
     * @param \Magento\Customer\Api\Data\AddressInterface $addressData
     * @param \Magento\Quote\Api\Data\CartInterface $quoteData
     * @param \Magento\Quote\Api\Data\CartItemInterface[] $itemsData
     * @param \Springbot\Main\Api\Entity\Data\Order\MarketplacesInterface $marketplaces
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

        if($this->findOrCreateCustomer()) {
            $this->buildCart();
        }


        // return order eventually
        return;
    }

    private function buildCart()
    {
        $this->quoteData->assignCustomer($this->customer);

        $this->cart = $this->quoteData
            ->setStoreId($this->getStore()->getId())
            ->save();

        foreach($this->quoteItemsData as $item) {
            $product = $this->productRepository->get($item->getSku());
            $product->setPrice($item->getPrice());
            $this->cart->addProduct(
                $product,
                intval($item->getQty()),
                \Magento\Catalog\Model\Product\Type\AbstractType::PROCESS_MODE_LITE
            );
        }

        $this->quoteRepository->save($this->cart);

        eval(\Psy\sh());

        $this->cart->setTotalsCollectedFlag(true);
        $this->cart->collectTotals();

        return $this->cart;
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
