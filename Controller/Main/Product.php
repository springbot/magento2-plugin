<?php

namespace Springbot\Main\Controller\Main;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Product
 * @package Springbot\Main\Controller
 */
class Product extends Action {

    protected $request;
    private $productFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->request        = $context->getRequest();
        $this->productFactory = $productFactory;
        parent::__construct( $context );
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {

        $resultJson = $this->resultFactory->create( ResultFactory::TYPE_JSON );
        try {
            $productId = $this->request->getParam( 'product_id' );
            $product   = $this->productFactory->create()->load( $productId );
            $children  = [];

            if ( $product->getId() == null ) {
                throw new \Exception( 'product not found' );
            }

            if ( $product->getTypeId() === 'configurable' ) {

                $superAttributes = $product
                    ->getTypeInstance( true )
                    ->getConfigurableAttributesAsArray( $product );

                $childProducts = $product->getTypeInstance()->getUsedProducts( $product );
                foreach ( $childProducts as $childProduct ) {

                    $superAttributeValues = [ $childProduct->getName() ];
                    foreach ( $superAttributes as $superAttribute ) {
                        $superAttributeValues[] = $childProduct
                            ->getResource()
                            ->getAttribute( $superAttribute['attribute_code'] )
                            ->getFrontend()
                            ->getValue( $childProduct );
                    }

                    $name = implode( ' / ', $superAttributeValues );

                    $children[] = [
                        'product_id' => $childProduct->getId(),
                        'sku'        => $childProduct->getSku(),
                        'name'       => $name,
                    ];
                }
            } else {
                $children[] = [
                    'name'       => $product->getName(),
                    'product_id' => $product->getId(),
                    'sku'        => $product->getSku(),
                ];
            }

            $resultJson->setData( [
                'successful' => true,
                'name'       => $product->getName(),
                'product_id' => $product->getId(),
                'sku'        => $product->getSku(),
                'children'   => $children,
            ] );

        } catch ( \Exception $e ) {

            $resultJson->setData( [
                'successful' => false,
                'message'    => $e->getMessage(),
            ] );

        }

        return $resultJson;
    }
}
