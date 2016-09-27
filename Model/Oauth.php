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

    protected $integrationService;
    protected $oauthService;
    protected $integrationData = [];

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
        $this->integrationService = $integrationService;
        $this->oauthService = $oauthService;
        parent::__construct($context, $registry);
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
        $integration = $this->integrationService->findByName('Springbot');
        if ($integration->isEmpty()) {
            $integration = $this->integrationService->create($this->integrationData);
        }

        if ($consumerId = $integration->getConsumerId()) {
            $this->oauthService->createAccessToken($integration->getConsumerId());
            $accessToken = $this->oauthService->getAccessToken($integration->getConsumerId());
            if (!$accessToken->isEmpty()) {
                return $accessToken->getToken();
            }
        }
        return false;
    }
}
