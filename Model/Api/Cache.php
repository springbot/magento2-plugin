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

    protected $cacheTypes =
    [
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
    ];

    /**
     * @param TypeListInterface $cacheTypeList
     * @param StateInterface $cacheState
     * @param Pool $pool
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
    public function clean($cacheType = null)
    {
        if ($cacheType) {
            if (in_array($cacheType, $this->cacheTypes, true)) {
                $this->cacheTypeList->cleanType($cacheType);
            }
        } else {
            foreach ($this->cacheTypes as $type) {
                $this->cacheTypeList->cleanType($type);
            }
        }
        return ['success'];
    }


    /**
     * @return string[]
     */
    public function getAvailableTypes()
    {
        $result = [];
        foreach ($this->cacheTypeList->getTypes() as $type) {
            $result[] = $type['id'];
        }
        return $result;
    }


    /**
     * Presents summary about cache status
     *
     * @return string[]
     */
    public function getStatus()
    {
        $result = [];
        foreach ($this->cacheTypeList->getTypes() as $type) {
            $result[$type['id']] = $type['status'];
        }
        return $result;
    }
}
