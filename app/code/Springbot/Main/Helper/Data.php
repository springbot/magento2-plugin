<?php

namespace Springbot\Main\Helper;

use Magento\Checkout\Model\ResourceModel\Cart;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Quote\Model\QuoteFactory;
use Magento\Checkout\Helper\Cart as CartHelper;
use Magento\Checkout\Model\Session;

/**
 * Class Data
 *
 * @package Springbot\Main\Helper
 */
class Data extends AbstractHelper
{
    const SPRINGBOT_REGISTRATION_URL = 'https://api.springbot.com/api/registration/login/';

    /**
     * @var Config
     */
    private $_config;

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var QuoteFactory
     */
    private $_quoteFactory;

    /**
     * @var Session
     */
    private $_session;

    /**
     * @var CartHelper
     */
    private $_cartHelper;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CartHelper $cartHelper,
        Config $config,
        Context $context,
        QuoteFactory $quoteFactory,
        Session $session,
        StoreManagerInterface $storeManager
    ) {
        $this->_cartHelper = $cartHelper;
        $this->_config = $config;
        $this->_quoteFactory = $quoteFactory;
        $this->_session = $session;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Check for GUID and if not found, generate it.
     *
     * @return string
     */
    public function getStoreGuid()
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $guid = $this->scopeConfig->getValue('springbot/configuration/store_guid_' . $storeId);
        if (empty($guid)) {
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $guid = substr($charid, 0, 8) . '-'
                . substr($charid, 8, 4) . '-'
                . substr($charid, 12, 4) . '-'
                . substr($charid, 16, 4) . '-'
                . substr($charid, 20, 12);
            $this->_config->saveConfig('springbot/configuration/store_guid_' . $storeId, $guid, 'default', 0);
        }
        return str_replace('-', '', $guid);
    }

    public function setQuote($quoteId, $suppliedSecurityHash)
    {
        // Instantiate Quote object and load the correct quote
        $quote = $this->_quoteFactory->create();
        $quote->load($quoteId);
        // Check to make sure the cart is allowed to be restored
        if ($this->scopeConfig->getValue('springbot/cart_restore/do_restore') == 1) {
            if ($quote) {
                // Get the current cart count
                $cartCount = $this->_cartHelper->getSummaryCount();
                if ($cartCount == 0) {
                    $quote->setIsActive(true)->save();
                    $token = $this->scopeConfig->getValue('springbot/configuration/security_token');
                    $correctSecurityHash = sha1($quoteId . $token);
                    if ($suppliedSecurityHash == $correctSecurityHash) {
                        if ($this->scopeConfig->getValue('springbot/cart_restore/retain_coupon') === 0) {
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
