<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Phrase;
use Magento\Framework\Webapi\Exception;
use Springbot\Main\Api\AmazonInterface;

/**
 * Class Redirects
 *
 * @package Springbot\Main\Model
 */
class Amazon implements AmazonInterface
{

    private $cartManagementInterface;
    private $cartRepositoryInterface;
    private $customerFactory;
    private $customerRepository;
    private $orderService;
    private $productFactory;
    private $productRepository;
    private $quoteManagement;
    private $request;
    private $shippingRate;
    private $storeConfiguration;
    private $storeManager;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Quote\Model\Quote\Address\Rate $shippingRate,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Sales\Model\Service\OrderService $orderService,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Springbot\Main\Model\StoreConfiguration $storeConfiguration
    ) {
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->quoteManagement = $quoteManagement;
        $this->request = $request;
        $this->shippingRate = $shippingRate;
        $this->storeConfiguration = $storeConfiguration;
        $this->storeManager = $storeManager;
    }

    /**
     * @param int $localStoreId
     * @param int $storeId
     * @param string $buyerEmail
     * @param string $buyerName
     * @param \Springbot\Main\Api\Amazon\Order\AddressInterface $shippingAddress
     * @param \Springbot\Main\Api\Amazon\Order\ItemInterface[] $orderItems
     * @return int
     * @throws \Exception
     */
    public function createOrder($localStoreId, $storeId, $buyerEmail, $buyerName, $shippingAddress, $orderItems)
    {
        // Load the store from the Springbot store ID
        $checkStoreId = $this->storeConfiguration->getSpringbotStoreId($localStoreId);
        if ($storeId != $checkStoreId) {
            throw new Exception(
                new Phrase("Local store ID {$localStoreId} does not correspond to springbot store {$storeId}")
            );
        }
        $store = $this->storeManager->getStore($localStoreId);

        // Init the customer
        $websiteId = $store->getWebsiteId();
        $customer = $this->customerFactory
            ->create()
            ->setWebsiteId($websiteId)
            ->loadByEmail($buyerEmail);

        // Create the customer if it doesn't exist already
        if (!$customer->getEntityId()) {
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($this->getFirstName($buyerName))
                ->setLastname($this->getLastName($buyerName))
                ->setEmail($buyerEmail)
                ->setPassword($this->randomPassword())
                ->save();
        }

        // Create the quote
        $cartId = $this->cartManagementInterface->createEmptyCart();
        $cart = $this->cartRepositoryInterface
            ->get($cartId)
            ->setStore($store)
            ->setCurrency();

        // if you have the buyer id then you can load customer directly
        $customer = $this->customerRepository->getById($customer->getEntityId());

        // Assign quote to customer
        $cart->assignCustomer($customer);

        // Add items in quote
        $shippingTotal = 0;
        foreach ($orderItems as $orderItem) {
            $tax = $orderItem->getGiftWrapTax()->getAmount()
                + $orderItem->getShippingTax()->getAmount()
                + $orderItem->getItemTax()->getAmount();
            $product = $this->productRepository->get($orderItem->getSellerSku());
            $cart->addProduct($product, $orderItem->getQuantityOrdered())
                ->setCustomPrice($orderItem->getItemPrice()->getAmount())
                ->setOriginalCustomPrice($orderItem->getItemPrice()->getAmount())
                ->setTaxAmount($tax);
            $shippingTotal += $orderItem->getShippingPrice()->getAmount();
        }

        $cart->getBillingAddress()->addData($shippingAddress->toArray());
        $cart->getShippingAddress()->addData($shippingAddress->toArray());

        // Collect Rates and Set Shipping & Payment Method
        $this->shippingRate
            ->setCode('sbmarketplaces')
            ->setPrice($shippingTotal);
        $cart->getShippingAddress()
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('sbmarketplaces')
            ->addShippingRate($this->shippingRate);

        // Set sales order payment
        $cart->getPayment()
            ->importData(['method' => 'sbmarketplaces']);
        $cart->collectTotals()
            ->save();
        $orderId = $this->cartManagementInterface->placeOrder($cart->getId());
        $this->getOrder($orderId)
            ->addStatusHistoryComment('Order synced from Amazon. Order ID: ' . $orderId)
            ->save();
        return $orderId;
    }

    /**
     * @param $orderId
     * @return mixed
     */
    private function getOrder($orderId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager->create('\Magento\Sales\Model\Order')->load($orderId);
    }

    /**
     * @param $buyerName
     * @return string
     */
    private function getFirstName($buyerName)
    {
        return $buyerName;
    }

    /**
     * @param $buyerName
     * @return string
     */
    private function getLastName($buyerName)
    {
        return $buyerName;
    }

    /**
     * @return string
     */
    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

}
