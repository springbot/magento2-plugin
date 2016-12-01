<?php

namespace Springbot\Main\Model\Api\Entity\Data\Order;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;
use Springbot\Main\Api\Entity\Data\Order\ItemAttributeInterface;
use Springbot\Main\Api\Entity\Data\Order\ItemInterface;
use Springbot\Main\Api\Entity\Data\Order\MarketplacesInterface;

/**
 * Class Item
 * @package Springbot\Main\Model\Entity\Data\Order
 */
class Marketplaces implements MarketplacesInterface
{
    private $currencyCode;
    private $shippingTotal;
    private $shippingTax;
    private $tax;
    private $region;
    private $marketplaceType;
    private $remoteOrderId;

    /**
     * Get currencyCode.
     *
     * @return null|string $currencyCode.
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Set currencyCode.
     *
     * @param null|string $currencycode
     * @return $this
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * Get shippingTotal.
     *
     * @return float $shippingTotal.
     */
    public function getShippingTotal()
    {
        return $this->shippingTotal;
    }

    /**
     * Set shippingTotal.
     *
     * @param float $shippingTotal
     * @return $this
     */
    public function setShippingTotal($shippingTotal = 0.0)
    {
        $this->shippingTotal = $shippingTotal;
        return $this;
    }

    /**
     * Get shippingTax.
     *
     * @return float $shippingTax.
     */
    public function getShippingTax()
    {
        return $this->shippingTax;
    }

    /**
     * Set shippingTax.
     *
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax = 0.0)
    {
        $this->shippingTax = $shippingTax;
        return $this;
    }

    /**
     * Get tax.
     *
     * @return float $tax.
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set tax.
     *
     * @param float $tax
     * @return $this
     */
    public function setTax($tax = 0.0)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * Get region.
     *
     * @return string|null region.
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set region.
     *
     * @param string|null $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get marketplaceType.
     *
     * @return string $marketplaceType.
     */
    public function getMarketplaceType()
    {
        return $this->marketplaceType;
    }

    /**
     * Set marketplaceType.
     *
     * @param string $marketplaceType
     * @return $this
     */
    public function setMarketplaceType($marketplaceType = 'amazon')
    {
        $this->marketplaceType = $marketplaceType;
        return $this;
    }

    /**
     * Get remoteOrderId.
     *
     * @return string $remoteOrderId.
     */
    public function getRemoteOrderId()
    {
        return $this->remoteOrderId;
    }

    /**
     * Set remoteOrderId.
     *
     * @param string $remoteOrderId
     * @return $this
     */
    public function setRemoteOrderId($remoteOrderId)
    {
        $this->remoteOrderId = $remoteOrderId;
        return $this;
    }
}
