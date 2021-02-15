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
}
