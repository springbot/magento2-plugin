<?php

namespace Springbot\Main\Model\Handler;

use Magento\Sales\Model\Order as MagentoOrder;
use Springbot\Main\Model\Handler;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote as MagentoQuote;

/**
 * Class Order
 *
 * @package Springbot\Main\Model\Handler
 */
class Quote extends Handler
{
    const API_PATH = 'carts';
    const ENTITIES_NAME = 'carts';

    /**
     * @param $storeId
     * @param $quoteId
     * @throws \Exception
     */
    public function handle($storeId, $quoteId)
    {
        $quote = $this->objectManager->get('Magento\Quote\Model\Quote');
        /* @var MagentoQuote $quote */
        $quote->load($quoteId);
        $array = $quote->toArray();
        $this->api->postEntities($storeId, self::API_PATH, self::ENTITIES_NAME, [$array]);
    }

    public function handleDelete($storeId, $quoteId)
    {
        $this->api->deleteEntity($storeId, self::API_PATH, self::ENTITIES_NAME, ['id' => $quoteId]);
    }
}
