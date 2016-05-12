<?php

namespace Springbot\Main\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class SpringbotQuoteRedirect extends AbstractModel
{

    private $_redirectFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param SpringbotQuoteRedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        SpringbotQuoteRedirectFactory $redirectFactory
    ) {
        $this->_init('Springbot\Main\Model\ResourceModel\SpringbotQuoteRedirect');
        $this->_redirectFactory = $redirectFactory;
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
