<?php

namespace Springbot\Main\Model\Handler;

use Springbot\Main\Model\Api;
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

    public function handle($storeId, $cartId)
    {

    }

    public function handleDelete($storeId, $cartId)
    {

    }

    /**
     * @param MagentoQuote $quote
     * @param $dataSource
     * @return array
     */
    public function parse(MagentoQuote $quote, $dataSource)
    {
        $quote->getAllItems();
        return [];
    }

}
