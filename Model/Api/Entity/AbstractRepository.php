<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\Store;
use Magento\Framework\DB\Select;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Api\Entity
 */
abstract class AbstractRepository
{
    protected $request;
    protected $objectManager;
    protected $resourceConnection;

    /**
     * AbstractRepository constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\App\ObjectManager $objectManager
     */
    public function __construct(Http $request, ResourceConnection $resourceConnection, ObjectManager $objectManager)
    {
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Magento\Framework\DB\Select $select
     * @throws \Exception
     */
    public function filterResults(Select $select)
    {
        $page = $this->request->getQuery('page', 1);
        if (!is_numeric($page)) {
            throw new \Exception("Page {$page} is not a valid integer");
        }

        $limit = $this->request->getQuery('limit', 100);
        if (!is_numeric($limit)) {
            throw new \Exception("Limit {$limit} is not a valid integer");
        }

        $select->limitPage((int)$page, (int)$limit);
    }

}
