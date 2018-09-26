<?php

namespace Springbot\Main\Model;

use Magento\Integration\Model\IntegrationService;
use Magento\Integration\Model\OauthService;

/**
 * Class Oauth
 *
 * @package Springbot\Main\Model
 */
class Oauth
{
    const email = 'magento@springbot.com';
    const name = 'Springbot';

    protected $integrationService;
    protected $oauthService;

    /**
     * @param IntegrationService $integrationService
     * @param OauthService       $oauthService
     */
    public function __construct(IntegrationService $integrationService, OauthService $oauthService)
    {
        $this->integrationService = $integrationService;
        $this->oauthService = $oauthService;
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
        $integration = $this->integrationService->findByName(self::name);
        if ($integration->isEmpty()) {
            $integration = $this->integrationService->create(
                [
                'name' => self::name,
                'email' => self::email,
                'status' => 1,
                'all_resources' => 1,
                ]
            );
        }

        if ($consumerId = $integration->getConsumerId()) {
            $this->oauthService->createAccessToken($integration->getConsumerId());
            $accessToken = $this->oauthService->getAccessToken($integration->getConsumerId());
            if (! $accessToken->isEmpty()) {
                return $accessToken->getToken();
            }
        }
        return false;
    }
}
