<?php

namespace Springbot\Main\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Springbot\Main\Controller
 */
class Index extends Action
{

    protected $request;
    protected $resultFactory;
    protected $session;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context,
     * @param \Magento\Checkout\Model\Session $session,
     * @param \Magento\Framework\App\Request\Http $request,
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $session,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->session = $session;
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($email = $this->request->getParam('email')) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $quote = $this->session->getQuote();
                if (!$quote->getCustomerEmail()) {
                    $hasQuoteAlready = true;
                    if (!$quote->hasEntityId()) {
                        $hasQuoteAlready = false;
                    }
                    $quote->setCustomerEmail($email);
                    $quote->save();
                    if (!$hasQuoteAlready) {
                        $this->session->setQuoteId($quote->getId());
                    }
                }
            }
        }

        // Return an empty JSON object for backward compatibility
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(new \stdClass());
        return $resultJson;
    }

}
