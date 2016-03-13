<?php

namespace Springbot\Main\Test\Unit\Controller\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject| \Springbot\Main\Controller\Adminhtml\Index\Index
     */
    private $indexControllerMock;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManager;

    public function setUp()
    {
        $this->indexControllerMock = $this->getControllerIndexMock(['getResultPageFactory']);
        $this->authorization = $this->getMockBuilder('Magento\Framework\AuthorizationInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
    }

    /**
     * @covers \Springbot\Main\Controller\Adminhtml\Index\Index::execute
     */
    public function testExecute()
    {
        $pageMock = $this->getPageMock(['setActiveMenu', 'addBreadcrumb', 'getConfig']);
        $pageMock->expects($this->once())
            ->method('setActiveMenu');
        $pageMock->expects($this->once())
            ->method('addBreadcrumb');

        $resultPageFactoryMock = $this->getResultPageFactoryMock(['create']);

        $resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->will($this->returnValue($pageMock));

        $this->indexControllerMock->expects($this->once())
            ->method('getResultPageFactory')
            ->will($this->returnValue($resultPageFactoryMock));

        $titleMock = $this->getTitleMock(['prepend']);
        $titleMock->expects($this->once())
            ->method('prepend');
        $configMock = $this->getConfigMock(['getTitle']);
        $configMock->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue($titleMock));
        $pageMock->expects($this->once())
            ->method('getConfig')
            ->will($this->returnValue($configMock));

        $this->indexControllerMock->execute();
    }

    /**
     * @dataProvider isAllowedDataProvider
     * @param $isAllowed
     */
    public function testIsAllowed($isAllowed)
    {
        $this->authorization->expects($this->any())
            ->method('isAllowed')
            ->will($this->returnValue($isAllowed));
        $model = $this->objectManager->getObject(
            'Springbot\Main\Block\Adminhtml\Main',
            ['authorization' => $this->authorization]
        );
        switch ($isAllowed) {
            case true:
                $this->assertEquals('select', $model->getType());
                $this->assertNull($model->getClass());
                break;
            case false:
                $this->assertEquals('hidden', $model->getType());
                $this->assertContains('hidden', $model->getClass());
                break;
        }
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
