<?php

namespace Springbot\Main\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Quote\Model\QuoteFactory;
use Psr\Log\LoggerInterface;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class CartReconstitutionObserver
 * @package Springbot\Main\Observer
 */
class CartReconstitutionObserver implements ObserverInterface
{
    private $_session;
    private $_action;
    private $_messageManager;
    private $_springbotHelper;
    private $_loggerInterface;
    private $_quoteFactory;
    private $_scopeConfig;

    /**
     * @param Action $action
     * @param ManagerInterface $messageManager
     * @param Session $session
     * @param QuoteFactory $quoteFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param SpringbotHelper $springbotHelper
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(
        Action $action,
        ManagerInterface $messageManager,
        Session $session,
        QuoteFactory $quoteFactory,
        ScopeConfigInterface $scopeConfig,
        SpringbotHelper $springbotHelper,
        LoggerInterface $loggerInterface
    ) {
        $this->_action = $action;
        $this->_session = $session;
        $this->_quoteFactory = $quoteFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_loggerInterface = $loggerInterface;
        $this->_messageManager = $messageManager;
        $this->_springbotHelper = $springbotHelper;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            if ($quoteId = $this->_action->getRequest()->getParam('quote_id')) {
                $suppliedSecurityHash = $this->_action->getRequest()->getParam('sec_key');
                $this->setQuote($quoteId, $suppliedSecurityHash);
            }
        } catch (LocalizedException $e) {
            $this->_messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_messageManager->addException($e, __('Cart Reconstitution error'));
        }
        return;
    }

    public function setQuote($quoteId, $suppliedSecurityHash)
    {
        // Instantiate Quote object and load the correct quote
        $quote = $this->_quoteFactory->create();
        $quote->load($quoteId);

        // Check to make sure the cart is allowed to be restored
        if ($this->_scopeConfig->getValue('springbot/cart_restore/do_restore') == 1) {
            if ($quote) {

                // Only set the quote if they don't already have one
                if (!$this->_session->hasQuote()) {
                    $quote->setIsActive(true)->save();
                    $token = $this->_scopeConfig->getValue('springbot/configuration/security_token');
                    $correctSecurityHash = sha1($quoteId . $token);
                    if ($suppliedSecurityHash == $correctSecurityHash) {
                        if ($this->_scopeConfig->getValue('springbot/cart_restore/retain_coupon') === 0) {
                            $quote->setCouponCode('');
                            $quote->save();
                        }
                        $this->_session->setQuoteId($quoteId);
                    }
                }
            }
        }
    }
}
