<?php

namespace Springbot\Main\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Config as OrderConfig;
use Springbot\Main\Helper\Data;
use Springbot\Main\Model\Api\Redirects;
use Magento\Framework\App\Cache\Manager;
use Psr\Log\LoggerInterface;

/**
 * Class Register
 *
 * @package Springbot\Main\Model
 */
class Register
{
    const api_class = 'stores';
    const platform = 'magento2';

    private $api;
    private $helper;
    private $orderConfig;
    private $storeManager;
    private $urlInterface;
    private $storeConfig;
    private $scopeConfigInterface;
    private $oauth;
    private $redirects;
    private $cacheManager;
    private $logger;

    /**
     * @param Api $api
     * @param Data $data
     * @param OrderConfig $orderConfig
     * @param ScopeConfigInterface $scopeConfigInterface
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $urlInterface
     * @param StoreConfiguration $storeConfig
     * @param Oauth $oauth
     * @param Redirects $redirects
     * @param Manager $cacheManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        Api $api,
        Data $data,
        OrderConfig $orderConfig,
        ScopeConfigInterface $scopeConfigInterface,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        StoreConfiguration $storeConfig,
        Oauth $oauth,
        Redirects $redirects,
        Manager $cacheManager,
        LoggerInterface $logger
    ) {
        $this->api = $api;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->helper = $data;
        $this->orderConfig = $orderConfig;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->storeConfig = $storeConfig;
        $this->oauth = $oauth;
        $this->redirects = $redirects;
        $this->cacheManager = $cacheManager;
        $this->logger = $logger;
    }

    /**
     * @param string $email
     * @param string $password
     * @param string|null $apiToken
     * @return bool
     */
    public function registerAllStores($email, $password, $apiToken = null)
    {
        $stores = $this->storeManager->getStores();
        return $this->registerStores($email, $password, $stores, $apiToken);
    }

    /**
     * Register all stores with Springbot via the ETL. Can be authed by either username/password or api_token.
     *
     * @param string|null $email
     * @param string|null $password
     * @param \Magento\Store\Api\Data\StoreInterface[]
     * @param string|null $apiToken
     * @return bool
     */
    public function registerStores($email, $password, $stores, $apiToken = null)
    {
        try {
            $url = $this->api->getApiUrl(Api::store_registration_path);
            $storesArray = $this->getStoresArray($stores);
            $om = ObjectManager::getInstance();
            $response = $this->api->post(
                $url,
                json_encode([
                    'stores'         => $storesArray,
                    'plugin_version' => $om->get('Magento\Framework\Module\ModuleList')->getOne('Springbot_Main')['setup_version'] . ".200",
                    'platform' => self::platform,
                    'access_token'   => $this->oauth->create(),
                    'credentials'    => [
                        'email'     => $email,
                        'password'  => $password,
                        'api_token' => $apiToken
                    ]
                ])
            );

            if ($responseArray = json_decode($response->getBody(), true)) {
                $securityToken = $responseArray['security_token'];
                $this->storeConfig->saveGlobalValue('security_token', $securityToken);
                foreach ($storesArray as $guid => $storeArray) {
                    if ($returnedStoreArray = $responseArray['stores'][$guid]) {
                        $localStoreId = $returnedStoreArray['json_data']['store_id'];
                        $this->storeConfig->saveValues($localStoreId, [
                            'store_guid'     => $guid,
                            'store_id'       => $returnedStoreArray['springbot_store_id'],
                            'security_token' => $securityToken
                        ]);

                        // Attempt to create the redirect, catch exception if it already exists
                        try {
                            $target = $this->scopeConfigInterface->getValue('springbot/configuration/app_url')
                                . '/i/'
                                . $returnedStoreArray['springbot_store_id'];

                            $this->redirects->createRedirect(
                                'i',
                                '301',
                                "springbot/{$localStoreId}",
                                $target,
                                $localStoreId,
                                "Springbot Instagram redirect for store {$localStoreId}"
                            );
                        } catch (\Throwable $t) {
                            $this->logger->error($t->getMessage());
                        }
                    }
                }

                $this->cacheManager->flush(['config', 'block_html', 'config_api', 'config_api2']);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $e) {
            return json_encode($e->getMessage(), true);
        }
    }

    /**
     * @return boolean
     */
    public function allStoresRegistered()
    {
        $stores = $this->storeManager->getStores();
        foreach ($stores as $store) {
            if (! $this->storeConfig->getSpringbotStoreId($store->getId()) ||
                ! $this->storeConfig->getGuid($store->getId())
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns an array of all stores on the instance with the necessary data to register the store with Springbot.
     *
     * @param \Magento\Store\Model\Store[] $stores
     * @return array
     */
    public function getStoresArray($stores)
    {
        $storesArray = [];

        foreach ($stores as $store) {
            $guid = $this->helper->getStoreGuid($store->getId());

            $storesArray[$guid] = [
                'guid'                => $guid,
                'url'                 => $store->getBaseUrl(),
                'name'                => $store->getName(),
                'logo_src'            => $this->scopeConfigInterface->getValue('design/header/logo_src'),
                'logo_alt_tag'        => $this->scopeConfigInterface->getValue('design/header/logo_atl'),
                'web_id'              => $store->getWebsiteId(),
                'store_id'            => $store->getId(),
                'store_name'          => $store->getName(),
                'store_code'          => $store->getCode(),
                'store_active'        => $store->isActive(),
                'store_url'           => $store->getBaseUrl(),
                'media_url'           => $this->urlInterface->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
                'store_mail_address'  => $this->getStoreAddress(),
                'store_custsrv_email' => $this->scopeConfigInterface->getValue('trans_email/ident_support/email'),
                'store_statuses'      => $this->orderConfig->getStatuses(),
            ];
        }
        return $storesArray;
    }

    protected function getStoreAddress()
    {
        return str_replace(
            ["\n", "\r"],
            "|",
            $this->scopeConfigInterface->getValue('general/store_information/address')
        );
    }
}
