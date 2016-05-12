<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class SpringbotOrderRedirect extends AbstractModel
{

    private $_redirectFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param SpringbotOrderRedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        SpringbotOrderRedirectFactory $redirectFactory
    ) {
        $this->_init('Springbot\Main\Model\ResourceModel\SpringbotOrderRedirect');
        $this->_redirectFactory = $redirectFactory;
        parent::__construct($context, $registry);
    }

    public function insert($orderId, $redirectMongoId)
    {
        $redirectModel = $this->_redirectFactory->create();
        $redirectModel->addData([
            'order_id' => $orderId,
            'redirect_string' => $redirectMongoId
        ]);
        $redirectModel->save();
    }

    public function getRedirectIds($orderId)
    {

    }

}
