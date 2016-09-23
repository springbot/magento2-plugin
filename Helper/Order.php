<?php

namespace Springbot\Main\Helper;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\AlreadyExistsException;
use Psr\Log\LoggerInterface as Logger;

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
     * @param \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory
     * @param \Magento\Customer\Model\ResourceModel\AddressRepository $addressRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Customer\Model\StoreRepository $storeRepository
     * @param \Magento\Directory\Helper\Data $regionHelper
     * @param \Magento\Directory\Model\Region $region
     * @param Logger $logger
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\ResourceModel\AddressRepository $addressRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreRepository $storeRepository,
        \Magento\Directory\Helper\Data $regionHelper,
        \Magento\Directory\Model\Region $region,
        Logger $logger
    ) {
        $this->objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
        $this->storeRepository = $storeRepository;
        $this->regionHelper = $regionHelper;
        $this->region = $region;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @param int $storeId
     * @param \Magento\Customer\Api\Data\CustomerInterface $customerData
     * @param \Magento\Quote\Api\Data\AddressInterface $addressData
     * @param \Magento\Quote\Api\Data\CartInterface $quoteData
     * @param \Magento\Quote\Api\Data\CartItemInterface[] $itemsData
     * @return \Springbot\Main\Api\Entity\Data\OrderInterface
     */
    public function buildOrder($storeId, $customerData, $addressData, $quoteData, $itemsData)
    {
        $this->storeId = $storeId;
        $this->customerData = $customerData;
        $this->addressData = $addressData;
        $this->quoteData = $quoteData;
        $this->quoteItemsData = $itemsData;

        $this->findOrCreateCustomer();

        // return order eventually
        return;
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
        return [
            $this->addressData
                ->setRegionId($this->getRegionId())
                ->setDefaultBilling(true)
                ->setDefaultShipping(true)
                ->getDataModel()
        ];
    }

    private function getRegionId()
    {
        if ($this->regionHelper->isRegionRequired($this->addressData->getCountryId())) {
            $this->region->loadByName($this->addressData->getRegion(), $this->addressData->getCountryId());
            $this->region->loadByCode($this->addressData->getRegion(), $this->addressData->getCountryId());
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
