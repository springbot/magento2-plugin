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
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $integrationFactory = $objectManager->get('Magento\Integration\Model\IntegrationFactory')->create();

        $integration = $integrationFactory->load(self::name,'name');
        $integrationExists = !$integration->isEmpty();
        if ($integrationExists) {
            // In some cases, the integration doesn't generate properly or entirely and may be missing the access token but still exist.
            $token = $this->oauthService->getAccessToken($integration->getConsumerId());
            if (empty($token)) {
                return false;
                // return 'empty access token for existing integration.';
                // return $this->fix($integration);
            }
            return $token->getToken();
        }

        $newIntegration = [
            'name' => self::name,
            'email' => self::email,
            'status' => 1,
            'all_resources' => 1,
        ];

        $integration = $integrationFactory->setData($newIntegration);
        $integration->save();
        $integrationId = $integration->getId();
        $consumerName = 'Springbot';

        $consumer = $this->oauthService->createConsumer(['name' => $consumerName]);
        $consumerId = $consumer->getId();
        $integration->setConsumerId($consumer->getId());
        $integration->save();

        $authrizeService = $objectManager->get('Magento\Integration\Model\AuthorizationService');
        $authrizeService->grantAllPermissions($integrationId);

        // Code to Activate and Authorize
        $token = $objectManager->get('Magento\Integration\Model\Oauth\Token');
        $uri = $token->createVerifierToken($consumerId);
        $token->setType('access');
        $token->save();
        
        $tokenOut = $this->oauthService->getAccessToken($consumerId)->getToken();

        return $tokenOut;
    }
}
