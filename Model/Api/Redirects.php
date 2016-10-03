<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\App\ResourceConnection;
use Springbot\Main\Api\RedirectsInterface;
use Springbot\Main\Model\Api\RedirectFactory;
use Springbot\Main\Model\Api\Entity\AbstractRepository;
use Magento\Framework\App\Request\Http;

/**
 * Class Redirects
 * @package Springbot\Main\Model
 */
class Redirects extends AbstractRepository implements RedirectsInterface
{

    private $redirectFactory;
    
    /**
     * @param \Magento\Framework\App\Request\Http $request
     * @param ResourceConnection $resourceConnection
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(Http $request, ResourceConnection $resourceConnection, RedirectFactory $redirectFactory)
    {
        $this->redirectFactory = $redirectFactory;
        parent::__construct($request, $resourceConnection);
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getRedirects($storeId)
    {
        $conn = $this->resourceConnection->getConnection();
        $select = $conn->select()
            ->from(['ur' => $conn->getTableName('url_rewrite')])
            ->where('store_id = ?', $storeId)
            ->where('entity_type = \'custom\'');
        $this->filterResults($select);
        $ret = [];
        foreach ($conn->fetchAll($select) as $row) {
            $redirect = $this->redirectFactory->create();
            $redirect->setValues(
                $row['url_rewrite_id'],
                $row['request_path'],
                $row['target_path'],
                $row['redirect_type'],
                $row['store_id'],
                $row['description']
            );
            $ret[] = $redirect;
        }
        return $ret;
    }
}