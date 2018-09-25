<?php

namespace Springbot\Main\Model\Api;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Config\ScopeConfigInterface;
;
use Magento\Framework\App\ResourceConnection;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Springbot\Main\Api\RedirectsInterface;
use Springbot\Main\Model\Api\RedirectFactory;
use Springbot\Main\Model\Api\Entity\AbstractRepository;

/**
 * Class Redirects
 *
 * @package Springbot\Main\Model
 */
class Redirects extends AbstractRepository implements RedirectsInterface
{

    private $redirectFactory;
    private $urlRewriteFactory;

    /**
     * @param \Magento\Framework\App\Request\Http $request
     * @param ResourceConnection                  $resourceConnection
     * @param RedirectFactory                     $redirectFactory
     * @param UrlRewriteFactory                   $urlRewriteFactory
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection,
        RedirectFactory $redirectFactory,
        UrlRewriteFactory $urlRewriteFactory
    ) {

        $this->redirectFactory = $redirectFactory;
        $this->urlRewriteFactory = $urlRewriteFactory;
        parent::__construct($request, $resourceConnection);
    }

    /**
     * @param int $storeId
     * @return string[]
     */
    public function getRedirects($storeId)
    {
        $resource = $this->resourceConnection;
        $conn = $resource->getConnection();
        $select = $conn->select()
            ->from(['ur' => $resource->getTableName('url_rewrite')])
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

    public function createRedirect($requestPath, $redirectType, $idPath, $targetPath, $storeId, $description)
    {
        $urlRewriteModel = $this->urlRewriteFactory->create();
        $urlRewriteModel->setEntityType('custom');
        $urlRewriteModel->setStoreId($storeId);
        $urlRewriteModel->setIsSystem(0);
        $urlRewriteModel->setIdPath($idPath);
        $urlRewriteModel->setRequestPath($requestPath);
        $urlRewriteModel->setTargetPath($targetPath);
        $urlRewriteModel->setRedirectType($redirectType);
        $urlRewriteModel->setDescription($description);
        $urlRewriteModel->save();
        return $urlRewriteModel;
    }
}
