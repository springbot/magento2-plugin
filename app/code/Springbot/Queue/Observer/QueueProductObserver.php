<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class QueueProductObserver
 * @package Springbot\Queue\Observer
 */
class QueueProductObserver implements ObserverInterface
{
    /**
     * Attributes we care about
     *
     * @var array
     */
    private $_attributes = [
        'entity_id',
        'sku',
        'attribute_set_id',
        'description',
        'full_description',
        'short_description',
        'image',
        'url_key',
        'small_image',
        'thumbnail',
        'status',
        'visibility',
        'price',
        'special_price',
        'image_label',
        'name',
    ];

    /**
     * @var LoggerInterface
     */
    private $_logger;

    /**
     * @var SpringbotHelper
     */
    private $_springbotHelper;

    /**
     * HarvestProductObserver constructor.
     *
     * @param LoggerInterface $loggerInterface
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        LoggerInterface $loggerInterface,
        SpringbotHelper $springbotHelper
    ) {
        $this->_logger = $loggerInterface;
        $this->_springbotHelper = $springbotHelper;
    }

    /**
     * Queue up product changes
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * Grab the product from the event
         */
        $product = $observer->getEvent()->getProduct();

        /**
         * Get the store Id
         */
        $storeId = $product->getStoreId();

        /**
         * Grab the product Id
         */
        $productId = $product->getId();

        /**
         * Schedule the job
         */
        $changedAttributes = [];

        if ($product->hasDataChanges()) {
            foreach ($this->_attributes as $attribute) {
                if ($product->dataHasChangedFor($attribute)) {
                    $changedAttributes[] = $attribute;
                }
            }
            $this->_springbotHelper->scheduleJob('updateProduct', [$storeId, $productId, $changedAttributes], 'Springbot\Main\Helper\HarvestProducts', 'listener', 5);
        }
    }
}
