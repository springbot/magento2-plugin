<?php

namespace Springbot\Main\Model\Api\Entity;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection;
use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\Store;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Api\Entity
 */
abstract class AbstractRepository implements ProductRepositoryInterface
{
    protected $request;
    protected $objectManager;

    /**
     * @return AbstractModel
     */
    abstract public function getSpringbotModel();

    /**
     * AbstractRepository constructor.
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @param Collection $collection
     * @throws \Exception
     */
    public function filterResults(Collection $collection)
    {
        $page = $this->request->getQuery('page', 1);
        if (!is_numeric($page)) {
            throw new \Exception("Page {$page} is not a valid integer");
        }

        $limit = $this->request->getQuery('limit', 100);
        if (!is_numeric($limit)) {
            throw new \Exception("Limit {$limit} is not a valid integer");
        }

        $collection->getSelect()->limitPage((int)$page, (int)$limit);
    }

    /**
     * @return Store
     */
    public function getStoreModel()
    {
        return $this->objectManager->create(Store::class);
    }
}
