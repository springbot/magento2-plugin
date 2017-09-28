<?php

namespace Springbot\Main\Model\Api;

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
    private $quoteManagement;
    private $shippingRate;
    private $storeManager;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Quote\Model\Quote\Address\Rate $shippingRate,
        \Magento\Quote\Model\QuoteManagement $quoteManagement,
        \Magento\Sales\Model\Service\OrderService $orderService,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->productFactory = $productFactory;
        $this->quoteManagement = $quoteManagement;
        $this->shippingRate = $shippingRate;
        $this->storeManager = $storeManager;
    }

    /**
     * Create Order On Your Store
     *
     * @param array $orderData
     * @return int $orderId
     *
     */
    public function createOrder($orderData)
    {
        $orderData = [
            'currency_id'      => 'USD',
            'email'            => 'ejacobs+test@springbot.com',
            'note'             => 'Created by amazon. Amazon Order ID: xxxxxx',
            'created_at'       => '',
            'shipping_address' => [
                'firstname'            => 'Shia',
                'lastname'             => 'Deo',
                'street'               => '1234 Fake St',
                'city'                 => 'Atlanta',
                'country_id'           => 'US',
                'region'               => 'GA',
                'postcode'             => '30365',
                'telephone'            => '1231231234',
                'fax'                  => '1231231234',
                'save_in_address_book' => 1
            ],
            'billing_address'  => [
                'firstname'            => 'Bill',
                'lastname'             => 'Jacobs',
                'street'               => '12 Peachtree St',
                'city'                 => 'Atlanta',
                'country_id'           => 'US',
                'region'               => 'GA',
                'postcode'             => '30324',
                'telephone'            => '1231231234',
                'fax'                  => '1231231234',
                'save_in_address_book' => 1
            ],
            'items'            => [
                ['product_id' => '1', 'qty' => 1, 'price' => 1, 'tax' => 44, 'sku' => 'foo'],
                ['product_id' => '2', 'qty' => 2, 'price' => 1, 'tax' => 11, 'sku' => 'bar']
            ]
        ];

        // Init the store id and website id
        // TODO: Get store from request path
        $store = $this->storeManager->getStore();
        $websiteId = $store->getWebsiteId();

        // Init the customer
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);

        // Load customer by email address
        $customer->loadByEmail($orderData['email']);

        // Check the customer
        if (!$customer->getEntityId()) {

            // Create the customer if it doesn't exist already
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($orderData['shipping_address']['firstname'])
                ->setLastname($orderData['shipping_address']['lastname'])
                ->setEmail($orderData['email'])
                ->setPassword($orderData['email']);
            $customer->save();
        }

        // Create the quote
        $cartId = $this->cartManagementInterface->createEmptyCart();
        $cart = $this->cartRepositoryInterface->get($cartId);
        $cart->setStore($store);

        // if you have the buyer id then you can load customer directly
        $customer = $this->customerRepository->getById($customer->getEntityId());
        $cart->setCurrency();

        // Assign quote to customer
        $cart->assignCustomer($customer);

        // Add items in quote
        foreach ($orderData['items'] as $item) {

            // TODO: Check for product id first, then use SKU
            $product = $this->productFactory->create()->load($item['product_id']);
            $product->setPrice($item['price']);
            $cart->addProduct($product, intval($item['qty']));
        }

        $cart->getBillingAddress()->addData($orderData['billing_address']);
        $cart->getShippingAddress()->addData($orderData['shipping_address']);

        // Collect Rates and Set Shipping & Payment Method
        $this->shippingRate
            ->setCode('sbmarketplaces')
            ->getPrice(1);
        $shippingAddress = $cart->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('sbmarketplaces')
            ->addShippingRate($this->shippingRate);

        // Set sales order payment
        $cart->getPayment()->importData(['method' => 'sbmarketplaces']);

        // Collect total and save
        $cart->collectTotals();

        // Submit the quote and create the order
        $cart->save();
        $cart = $this->cartRepositoryInterface->get($cart->getId());
        $orderId = $this->cartManagementInterface->placeOrder($cart->getId());

        $order = $this->getOrder($orderId);
        $order->addStatusHistoryComment('This comment is programatically added to last order in this Magento setup')
            ->save();
        return $orderId;
    }

    private function getOrder($orderId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager->create('\Magento\Sales\Model\Order')->load($orderId);
    }

}
