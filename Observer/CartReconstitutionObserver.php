<?php

namespace Springbot\Main\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\UrlInterface;
use Magento\Quote\Model\QuoteFactory;
use Psr\Log\LoggerInterface;
use Springbot\Main\Helper\Data as SpringbotHelper;

/**
 * Class CartReconstitutionObserver
 *
 * @package Springbot\Main\Observer
 */
class CartReconstitutionObserver implements ObserverInterface
{
    private $session;
    private $request;
    private $response;
    private $url;
    private $messageManager;
    private $springbotHelper;
    private $loggerInterface;
    private $quoteFactory;
    private $scopeConfig;

    /**
     * @param HttpRequest $request
     * @param ManagerInterface $messageManager
     * @param Session $session
     * @param UrlInterface $url
     * @param QuoteFactory $quoteFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param SpringbotHelper $springbotHelper
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(
        HttpRequest $request,
        UrlInterface $url,
        ManagerInterface $messageManager,
        Session $session,
        QuoteFactory $quoteFactory,
        ScopeConfigInterface $scopeConfig,
        SpringbotHelper $springbotHelper,
        LoggerInterface $loggerInterface
    ) {
        $this->request = $request;
        $this->url = $url;
        $this->session = $session;
        $this->quoteFactory = $quoteFactory;
        $this->scopeConfig = $scopeConfig;
        $this->loggerInterface = $loggerInterface;
        $this->messageManager = $messageManager;
        $this->springbotHelper = $springbotHelper;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */

    public function execute(Observer $observer)
    {
        try {
            if ($quoteId = $this->request->getParam('quote_id')) {
                $suppliedSecurityHash = $this->request->getParam('sec_key');
                $this->setQuote($quoteId, $suppliedSecurityHash);
                $cartRedirect = $this->url->getUrl('checkout/cart');
                $observer->getControllerAction()->getResponse()->setRedirect($cartRedirect);
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Cart Reconstitution error'));
        }
        return $this;
    }

    public function setQuote($quoteId, $suppliedSecurityHash)
    {
        $quote = $this->session->getQuote();

        if (! is_object($quote)) {
            $cartIsEmpty = true;
        } elseif (! $quote->getItemsCount()) {
            $cartIsEmpty = true;
        } else {
            $cartIsEmpty = false;
        }

        // Check to make sure the cart is allowed to be restored and current cart is empty
        if ($cartIsEmpty && ($this->scopeConfig->getValue('springbot/cart_restore/do_restore') == 1)) {
            // Instantiate Quote object and load the correct quote
            $quote = $this->quoteFactory->create();
            $quote->load($quoteId);

            if ($quote) {
                $quote->setIsActive(true)->save();
                $token = $this->scopeConfig->getValue('springbot/configuration/security_token');
                $correctSecurityHash = sha1($quoteId . $token);
                if ($suppliedSecurityHash == $correctSecurityHash) {
                    if ($this->scopeConfig->getValue('springbot/cart_restore/retain_coupon') === 0) {
                        $quote->setCouponCode('');
                        $quote->save();
                    }
                    $this->session->setQuoteId($quoteId);
                }
            }
        }
    }
}
