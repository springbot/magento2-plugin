<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Springbot\Main\Model\SpringbotTrackableFactory;

/**
 * Class SpringbotTrackable
 * @package Springbot\Main\Model
 */
class SpringbotTrackable extends AbstractModel
{

    private $trackableFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param SpringbotTrackableFactory $trackableFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        SpringbotTrackableFactory $trackableFactory
    ) {
        $this->_init('Springbot\Main\Model\ResourceModel\SpringbotQuoteRedirect');
        $this->trackableFactory = $trackableFactory;
        parent::__construct($context, $registry);
    }

    public function insert($quoteId, $redirectMongoId)
    {
        $redirectModel = $this->trackableFactory->create();
        $redirectModel->addData([
            'quote_id' => $quoteId,
            'redirect_string' => $redirectMongoId
        ]);
        $redirectModel->save();
    }

    public function getRedirectIds($quoteId)
    {
    }
}
