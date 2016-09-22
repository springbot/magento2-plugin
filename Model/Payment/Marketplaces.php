<?php

namespace Springbot\Main\Model\Payment;

class Marketplaces extends \Magento\Payment\Model\Method\AbstractMethod
{
    const CODE = 'sbmarketplaces';

    const INFO_KEY_TITLE = 'sbmarketplaces';

    /**
     * @var string
     */
    protected $_code = self::CODE;

    /**
     * @var string
     */
    protected $_infoBlockType = 'Springbot\Main\Block\Payment\Info\Marketplaces';

    /**
     * Retrieve payment method title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getInfoInstance()->getAdditionalInformation(self::INFO_KEY_TITLE);
    }
}
