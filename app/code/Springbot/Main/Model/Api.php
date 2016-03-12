<?php

namespace Springbot\Main\Model;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Helper\Data;

/**
 * Class Api
 * @package Springbot\Main\Model
 */
class Api extends AbstractModel
{
    const SUCCESSFUL_RESPONSE = 'ok';
    const HTTP_CONTENT_TYPE = 'Content-type: application/json';
    const TOTAL_POST_FAIL_LIMIT = 32;
    const RETRY_LIMIT = 3;

    /**
     * @var string
     */
    private $_securityToken;

    /**
     * @var int
     */
    private $_retries;

    /**
     * @var Data
     */
    private $_springbotHelper;

    /**
     * @var ScopeConfigInterface
     */
    private $_scopeConfig;

    /**
     * @var \Zend_Http_client
     */
    private $_client;

    /**
     * @var string
     */
    private $_url;

    /**
     * @var EncryptorInterface
     */
    private $_encrypt;

    /**
     * Api constructor.
     * @param Data $springbotHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Data $springbotHelper,
        EncryptorInterface $encryptorInterface,
        ScopeConfigInterface $scopeConfig,
        Context $context,
        Registry $registry
    ) {
        $this->_encrypt = $encryptorInterface;
        $this->_springbotHelper = $springbotHelper;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $registry);
    }

    /**
     * @param $model
     * @param $data
     * @return string
     */
    public function wrap($model, $data)
    {
        $transport = new \stdClass();
        $transport->$model = $data;

        return \Zend_Json::encode($transport, false, ['enableJsonExprFinder' => true]);
    }

    /**
     * @return $this
     */
    public function reinit()
    {
        $this->_retries = 0;

        return $this;
    }

    /**
     * @param $method
     * @param bool $payload
     * @param bool $authenticate
     * @param string $httpMethod
     * @return array|mixed
     * @throws \Exception
     * @throws \Zend_Http_Client_Exception
     */
    public function call($method, $payload = false, $authenticate = true, $httpMethod = \Zend_Http_Client::POST)
    {
        $result = [];
        $client = $this->getClient($httpMethod);
        $client->setUri($this->getApiUrl($method));

        if ($authenticate) {
            $this->authenticate();
            $client->setHeaders('X-AUTH-TOKEN:' . $this->_springbotHelper->getSecurityToken());
        }

        if ($payload) {
            $client->setRawData(utf8_encode($payload));
        }

        try {
            $response = $client->request();

            if ($response->isSuccessful()) {
                $result = json_decode($response->getBody(), true);

                if ($result['status'] != self::SUCCESSFUL_RESPONSE) {
                    $this->_logger->error($response->getBody());
                }
            }
        } catch (\Exception $e) {
            $code = isset($result['status']) ? $result['status'] : 'null';

            throw new \Exception("$method call failed with code: $code");
        }

        return $result;
    }

    /**
     * @param string $method
     * @return \Zend_Http_Client
     * @throws \Zend_Http_Client_Exception
     */
    public function getClient($method = \Zend_Http_Client::POST)
    {
        $this->_client = new \Zend_Http_Client();
        $this->_client->setMethod($method);
        $this->_client->setHeaders(self::HTTP_CONTENT_TYPE);

        return $this->_client;
    }

    /**
     * @param string $method
     * @return string
     */
    public function getApiUrl($method = '')
    {
        if (!isset($this->_url)) {
            $this->_url = $this->_scopeConfig->getValue('springbot/configuration/api_url');
            if (!$this->_url) {
                $this->_url = 'https://api.springbot.com/';
            }
            $this->_url .= 'api/';
        }
        return $this->_url . $method;
    }

    /**
     * @throws \Exception
     */
    public function authenticate()
    {
        if (!$this->hasToken()) {
            $credentials = $this->_getApiCredentials();
            $result = $this->call('registration/login', $credentials, false);

            if (!isset($result['token'])) {
                throw new \Exception('Token not available in api response. Please check springbot credentials.');
            }

            $this->_securityToken = $result['token'];
        }

        return;
    }

    public function apiPostWrapped($model, $struct, $arrayWrap = false)
    {
        if ($arrayWrap) {
            $struct = [$struct];
        }

        $payload = $this->wrap($model, $struct);

        return $this->reinit()->call($model, $payload);
    }

    public function hasToken()
    {
        $token = $this->_scopeConfig->getValue('springbot/config/security_token');
        if ($token) {
            $this->_securityToken = $token;
        }

        return isset($this->_securityToken);
    }

    protected function _getApiCredentials()
    {
        $post = [
            'user_id' => $this->_getAccountEmail(),
            'password' => $this->_getAccountPassword(),
        ];
        return json_encode($post);
    }

    protected function _getAccountEmail()
    {
        return $this->_scopeConfig->getValue('springbot/config/account_email');
    }

    protected function _getAccountPassword()
    {
        $passwd = $this->_scopeConfig->getValue('springbot/config/account_password');
        return $this->_encrypt->decrypt($passwd);
    }
}
