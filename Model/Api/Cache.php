<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
use Springbot\Main\Api\CacheInterface;

/**
 * Class Cache
 * @package Springbot\Main\Api
 */
class Cache extends AbstractModel implements CacheInterface
{
    /**
     * Cache types list
     *
     * @var TypeListInterface
     */
    private $cacheTypeList;

    /**
     * Cache state service
     *
     * @var StateInterface
     */
    private $cacheState;

    /**
     * Cache types pool
     *
     * @var Type\FrontendPool
     */
    private $pool;

    protected $cacheTypes = array
    (
        'config',
        'layout',
        'block_html',
        'collections',
        'reflection',
        'db_ddl',
        'eav',
        'config_integration',
        'config_integration_api',
        'full_page',
        'translate',
        'config_webservice'
    );

    /**
     * @param Context $context
     */
    public function __construct(
        TypeListInterface $cacheTypeList,
        StateInterface $cacheState,
        Pool $pool
    ) {
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheState = $cacheState;
        $this->pool = $pool;
    }

    /**
     * Cleans up caches
     *
     * @param string $cacheType
     * @return string|null
     */
    public function clean($cacheType=null)
    {
        try {
            if ($cacheType) {
                $this->cacheTypeList->cleanType($cacheType);
            } else {
                foreach ($this->cacheTypes as $type) {
                    $this->cacheTypeList->cleanType($type);
                }
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
        return 'success';
    }
}
