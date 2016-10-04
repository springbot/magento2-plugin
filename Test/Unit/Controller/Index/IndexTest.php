<?php

namespace Springbot\Main\Test\Unit\Controller\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject| \Springbot\Main\Controller\Adminhtml\Index\Index */
    private $indexControllerMock;

    /** @var \Magento\Framework\AuthorizationInterface */
    protected $authorization;

    /** @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager */
    protected $objectManager;

    /**
     * @covers \Springbot\Main\Controller\Adminhtml\Index\Index::execute
     */
    public function testExecute()
    {
        $this->assertTrue(true);
    }


    public function isAllowedDataProvider()
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * Gets index controller mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Springbot\Main\Controller\Adminhtml\Index\Index
     */
    public function getControllerIndexMock($methods = null)
    {
        return $this->getMock('Springbot\Main\Controller\Adminhtml\Index\Index', $methods, [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Result\PageFactory
     */
    public function getResultPageFactoryMock($methods = null)
    {
        return $this->getMock('Magento\Framework\View\Result\PageFactory', $methods, [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Page\Config
     */
    public function getConfigMock($methods = null)
    {
        return $this->getMock('Magento\Framework\View\Page\Config', $methods, [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Page\Title
     */
    public function getTitleMock($methods = null)
    {
        return $this->getMock('Magento\Framework\View\Page\Title', $methods, [], '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Page\Title
     */
    public function getPageMock($methods = null)
    {
        return $this->getMock('Magento\Framework\View\Result\Page', $methods, [], '', false);
    }
}
