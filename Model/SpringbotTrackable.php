<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class SpringbotTrackable extends AbstractModel
{

    private $trxck;

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
        $this->_redirectFactory = $trackableFactory;
        parent::__construct($context, $registry);
    }

    public function insert($quoteId, $redirectMongoId)
    {
        $redirectModel = $this->_redirectFactory->create();
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
