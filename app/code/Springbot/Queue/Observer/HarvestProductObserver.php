<?php

namespace Springbot\Queue\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Springbot\Main\Helper\HarvestProducts as HarvestProductsHelper;
use Springbot\Queue\Helper\Data as SpringbotHelper;

/**
 * Class HarvestProductObserver
 * @package Springbot\Queue\Observer
 */
class HarvestProductObserver implements ObserverInterface
{
    /**
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
     * @var HarvestProductsHelper
     */
    protected $_harvestProductsHelper;

    /**
     * HarvestProductObserver constructor.
     *
     * @param LoggerInterface $loggerInterface
     * @param SpringbotHelper $springbotHelper
     */
    public function __construct(
        HarvestProductsHelper $harvestProductsHelper,
        LoggerInterface $loggerInterface,
        SpringbotHelper $springbotHelper
    ) {
        $this->_harvestProductsHelper = $harvestProductsHelper;
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
         * If the attributes we care about have changed, queue it up in the database
         */
        if ($product->dataHasChangedFor('name'))
            $this->_springbotHelper->scheduleJob('updateProduct', ["1", "1"], 'Springbot\Main\Helper\HarvestProducts', 'listener', 5);
            $this->_harvestProductsHelper->updateProduct(1, 1);
        }
}
