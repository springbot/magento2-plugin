<?php

namespace Springbot\Main\Model;

use Magento\Integration\Model\IntegrationService;
use Magento\Integration\Model\OauthService;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class Oauth
 *
 * @package Springbot\Main\Model
 */
class Oauth extends AbstractModel
{

    protected $_integrationService;
    protected $_oauthService;
    protected $_integrationData = [];

    /**
     * @param IntegrationService $integrationService
     * @param OauthService $oauthService
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        IntegrationService $integrationService,
        OauthService $oauthService,
        Context $context,
        Registry $registry
    ) {
        $this->_integrationService = $integrationService;
        $this->_oauthService = $oauthService;
        $this->_integrationData['name'] = 'Springbot';
        $this->_integrationData['email'] = 'magento@springbot.com';
        $this->_integrationData['endpoint'] = 'https://app.springbot.com/registration/stores';
        $this->_integrationData['status'] = 1;
        $this->_integrationData['all_resources'] = 1;
        parent::__construct($context, $registry);
    }

    /**
     * @return OauthService
     */
    public function oauthService()
    {
        return $this->_oauthService;
    }

    /**
     * Generate the Springbot Oauth keys
     *
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Oauth\Exception
     */
    public function create()
    {
        $integration = $this->_integrationService->findByName('Springbot');
        if (!$integration) {
            $integration = $this->_integrationService->create($this->_integrationData);
        }
        $accessToken =  $this->oauthService()->getAccessToken($integration->getConsumerId());

        $accessToken->get(1);
        $accessToken->save();
        return $accessToken;
    }
}
