<?php

namespace Springbot\Main\Api\Entity\Data;

/**
 * @package Springbot\Main\Api\Entity\Data
 */
interface RemoteOrderInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * @return string|null order increment id
     */
    public function getIncrementId();

    /**
     * @param string|null order increment id
     * @return $this
     */
    public function setIncrementId($id);

    /**
     * @return int|null order entity id
     */
    public function getOrderId();

    /**
     * @param int|null order entity id
     * @return $this
     */
    public function setOrderId($id);

    /**
     * @return string|null remote marketplace order id
     */
    public function getRemoteOrderId();

    /**
     * @param string|null remote marketplace order id
     * @return $this
     */
    public function setRemoteOrderId($id);
}
