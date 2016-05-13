<?php

namespace Springbot\Main\Model\Entity;

use Magento\Framework\Data\Collection;
use Springbot\Main\Api\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Entity
 */
abstract class AbstractRepository implements ProductRepositoryInterface
{
    protected $request;

    /**
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

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

}
