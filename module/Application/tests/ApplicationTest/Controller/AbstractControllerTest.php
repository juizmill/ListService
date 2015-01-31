<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\TestCaseController;
use Application\Controller\IndexController;

/**
 * Class AbstractControllerTest
 * @package ApplicationTest\Controller
 */
class AbstractControllerTest extends TestCaseController
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\AbstractController'));
        $this->assertInstanceOf('Zend\Mvc\\Controller\\AbstractActionController', $this->getMockAbstractController());
    }

    public function testChecksRequiredConstant()
    {
        $controller = $this->getMockAbstractController();

        $this->assertEquals('add_entity_namespace', $controller::ENTITY_NAMESPACE);
        $this->assertEquals('add_route_name', $controller::ROUTE_NAME);
        $this->assertEquals('add_controller_name', $controller::CONTROLLER_NAME);
        $this->assertEquals('add_form_namespace', $controller::FORM_NAMESPACE);
        $this->assertEquals(20, $controller::ITEM_PER_PAGE);
    }

    public function dataProviderMethods()
    {
        return array(
            array('indexAction'),
            array('newAction'),
            array('editAction'),
            array('deleteAction'),
            array('getEm'),
        );
    }

    /**
     * @dataProvider dataProviderMethods
     */
    public function testCheckMethodsEspecteds($method)
    {
        $this->assertTrue(method_exists('\\Application\\Controller\\AbstractController', $method));
    }

    public function testIfAttributEMExist()
    {
        $this->assertClassHasAttribute('em', '\\Application\\Controller\\AbstractController');
    }

    public function testReturnMethodEm()
    {
        $controller = $this->getMockAbstractController();
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $controller->getEm());
    }

    public function testReturnMethodIndexAction()
    {
        /**
         * @var $controller \Application\Controller\AbstractController
         * @var $viewModel \Zend\View\Model\ViewModel
         */
        $controller = $this->getMockAbstractController();
        $viewModel = $controller->indexAction();
        $params = $viewModel->getVariables();

        $this->assertInstanceOf('\\Zend\\View\\Model\\ViewModel', $viewModel);
        $this->assertInstanceOf('\\Zend\\Paginator\\Paginator', $params['data']);
    }

    /**
     * get mock abstract controller
     *
     * @return \Application\Controller\AbstractController
     */
    private function getMockAbstractController()
    {
        $parameter = $this->getMockBuilder('\\Zend\\Mvc\\Controller\\Plugin\\Params')->getMock();
        $redirect = $this->getMockBuilder('\\Zend\Mvc\\Controller\\Plugin\\Redirect')->getMock();

        $mock = $this->getMock('\\Application\\Controller\\AbstractController', array(
            'params',
            'fromRoute',
            'redirect',
            'toRoute',
            'getEm'), array(), '', false);

        $mock->expects($this->any())
                ->method('params')
                ->will($this->returnValue($parameter));

        $mock->expects($this->any())
                ->method('fromRoute')
                ->will($this->returnValue(null));

        $mock->expects($this->any())
                ->method('redirect')
                ->will($this->returnValue($redirect));

        $mock->expects($this->any())
                ->method('toRoute')
                ->will($this->returnValue(null));

        $mock->expects($this->any())
                ->method('getEm')
                ->will($this->returnValue($this->getEmMock()));

        return $mock;
    }

    private function getEmMock()
    {
        $erepository = $this->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')
                ->disableOriginalConstructor()
                ->getMock();

        $emMock = $this->getMock('\\Doctrine\\ORM\\EntityManager', array('persist', 'flush', 'getReference', 'remove', 'getRepository', 'find', 'findAll', 'merge'), array(), '', false);
        $emMock->expects($this->any())
                ->method('persist')
                ->will($this->returnValue(null));
        $emMock->expects($this->any())
                ->method('remove')
                ->will($this->returnValue(null));
        $emMock->expects($this->any())
                ->method('merge')
                ->will($this->returnValue(null));
        $emMock->expects($this->any())
                ->method('flush')
                ->will($this->returnValue(null));
        $emMock->expects($this->any())
                ->method('getRepository')
                ->will($this->returnValue($erepository));
        $emMock->expects($this->any())
                ->method('find')
                ->will($this->returnValue(null));
        $emMock->expects($this->any())
                ->method('findAll')
                ->will($this->returnValue(null));
        return $emMock;
    }
}
