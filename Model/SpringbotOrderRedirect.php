<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class SpringbotOrderRedirect extends AbstractModel
{
    const redirect_string_length = 24;

    private $redirectFactory;

    /**
     * @param Context                       $context
     * @param Registry                      $registry
     * @param SpringbotOrderRedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        SpringbotOrderRedirectFactory $redirectFactory
    ) {
        $this->_init('Springbot\Main\Model\ResourceModel\SpringbotOrderRedirect');
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context, $registry);
    }

    public function insert($orderId, $redirectMongoId)
    {
        if ($orderId && (strlen($redirectMongoId) == self::redirect_string_length)) {
            $redirectModel = $this->redirectFactory->create();
            $redirectModel->addData(
                [
                'order_id' => $orderId,
                'redirect_string' => $redirectMongoId
                ]
            );
            $redirectModel->save();
        }
    }
}
