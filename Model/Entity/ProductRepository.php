<?php

namespace Springbot\Main\Model\Entity;

use Springbot\Main\Api\Entity\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

/**
 * Class ProductRepository
 * @package Springbot\Main\Model\Entity
 */
class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    private $_springbotProductFactory;

    /**
     * @param Data\ProductFactory $productFactory
     * @param HttpRequest $request
     */
    public function __construct(Data\ProductFactory $productFactory, HttpRequest $request)
{
    $this->_springbotProductFactory = $productFactory;
        parent::__construct($request);
    }

    public function getFromId($storeId, $productId)
{
    $product = $this->_springbotProductFactory->create();
        $product->load($productId);
        return $product;
    }

    public function getList($storeId)
{
    $factory = $this->_springbotProductFactory;
        $product = $factory->create();
        $collection = $product->getCollection();
        $collection->addStoreFilter($storeId);
        $this->filterResults($collection);
        $ret = [];
        foreach ($collection->getAllIds() as $id) {
            $ret[] = $this->getFromId($storeId, $id);
        }
        return $ret;
    }

}
