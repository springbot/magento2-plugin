<?php

namespace Springbot\Main\Model\Marketplaces;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Springbot\Main\Api\Data\Marketplaces\RemoteOrderInterface;

class RemoteOrder extends AbstractModel implements ShippingAssignmentInterface
{
    private $_remoteOrderFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param RemoteOrderFactory $remoteOrderFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        RemoteOrderFactory $remoteOrderFactory
    ) {
        $this->_init('Springbot\Main\Model\ResourceModel\Marketplaces\RemoteOrder');
        $this->_remoteOrderFactory = $remoteOrderFactory;
        parent::__construct($context, $registry);
    }

    public function assignOrderId(\Magento\Sales\Model\Order $order, $remoteOrderId, $marketplace = 'amazon')
    {
        try {
            $remoteOrder = $this->_remoteOrderFactory->create();
            $remoteOrder->addData([
                'remote_order_id' => $remoteOrderId,
                'order_id' => $order->getEntityId(),
                'increment_id' => $order->getIncrementId(),
                'marketplace_type' => $marketplace
            ]);
            $remoteOrder->save();
        } catch($e) {
            eval(\Psy\sh());
        }
    }
}
