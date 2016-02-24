<?php

namespace Springbot\Queue\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Springbot\Queue\Model\QueueFactory;
use Magento\Catalog\Model\ProductFactory;

/**
 * Class Data
 *
 * @package Springbot\Queue\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var array
     */
    protected $_attributes = [];

    /**
     * @var QueueFactory
     */
    private $_queueFactory;

    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param QueueFactory $queueFactory
     */
    public function __construct(
        Context $context,
        QueueFactory $queueFactory,
        ProductFactory $productFactory
    ) {
        $this->_queueFactory = $queueFactory;
        $this->_productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * @param $method
     * @param array $args
     * @param $priority
     * @param string $queue
     * @param null $storeId
     * @param int $minutesInFuture
     */
    public function scheduleJob(
        $method,
        array $args,
        $class,
        $queue = 'default',
        $priority,
        $minutesInFuture = 0
    ) {
        $queueModel = $this->_queueFactory->create();
        $queueModel->addData([
            'method' => $method,
            'args' => json_encode($args),
            'class' => $class,
            'command_hash' => sha1($method . json_encode($args)),
            'queue' => $queue,
            'priority' => $priority,
            'next_run_at' => date("Y-m-d H:i:s")
        ]);
        $queueModel->save();
    }
}
