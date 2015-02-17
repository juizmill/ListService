<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\TestCase;
use ApplicationTest\Model\ExempleEntity;
use ReflectionClass;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class AbstractControllerTest
 *
 * @package ApplicationTest\Controller
 */
class AbstractControllerTest extends TestCase
{
    private $class;
    /**
     * @var $classExemple \ApplicationTest\Model\ExempleEntity
     */
    private $classExemple;

    public function setUp()
    {
        parent::setup();
        $this->classExemple = new ExempleEntity();
        $this->class = '\\Application\\Controller\\AbstractController';
    }

    public function testCheckIfClassExists()
    {
        $this->assertTrue(class_exists($this->class));
        $this->assertInstanceOf(
            '\\Zend\\Mvc\\Controller\\AbstractActionController',
            $this->getMockAbstractController()
        );
    }

    public function testCheckIfAttributeExpectedsExists()
    {
        $this->assertClassHasAttribute('model', $this->class);
        $this->assertClassHasAttribute('form', $this->class);
        $this->assertClassHasAttribute('route', $this->class);
        $this->assertClassHasAttribute('controller', $this->class);
        $this->assertClassHasAttribute('itemPerPage', $this->class);
    }

    public function testIfAttributeSetInConstructor()
    {
        $class = new ReflectionClass($this->class);
        $model = $class->getProperty("model");
        $model->setAccessible(true);

        $form = $class->getProperty("form");
        $form->setAccessible(true);

        $route = $class->getProperty("route");
        $route->setAccessible(true);

        $controller = $class->getProperty("controller");
        $controller->setAccessible(true);

        $itemPerPage = $class->getProperty("itemPerPage");
        $itemPerPage->setAccessible(true);

        $this->assertNotEmpty($model->getValue($this->getMockAbstractController()));
        $this->assertNotEmpty($form->getValue($this->getMockAbstractController()));
        $this->assertNotEmpty($route->getValue($this->getMockAbstractController()));
        $this->assertNotEmpty($controller->getValue($this->getMockAbstractController()));
        $this->assertNotEmpty($itemPerPage->getValue($this->getMockAbstractController()));
    }

    public function testCheckIfExistsMethodsExpected()
    {
        $this->assertTrue(method_exists($this->getMockAbstractController(), 'indexAction'));
        $this->assertTrue(method_exists($this->getMockAbstractController(), 'newAction'));
        $this->assertTrue(method_exists($this->getMockAbstractController(), 'editAction'));
        $this->assertTrue(method_exists($this->getMockAbstractController(), 'deleteAction'));
    }

    /**
     * @expectedException \Exception
     */
    public function testReturnIndexAction()
    {
        /**
         * @var $action \Zend\View\Model\ViewModel
         */
        $controller = $this->getMockAbstractController();
        $action = $controller->indexAction();

        $this->assertInstanceOf('\\Zend\\View\\Model\\ViewModel', $action);
        $this->assertInstanceOf('\\Zend\\Paginator\\Paginator', $action->getVariable('data'));
    }

    public function testReturnNewAction()
    {
        /**
         * @var $action \Zend\View\Model\ViewModel
         * @var $request \Zend\Http\Request
         */
        $controller = $this->getMockAbstractController();
        $action = $controller->newAction();

        $this->assertInstanceOf('\\Zend\\View\\Model\\ViewModel', $action);
        $this->assertInstanceOf('\\Zend\\Form\\Form', $action->getVariable('form'));
    }

    /**
     * @return \Application\Controller\AbstractController
     */
    private function getMockAbstractController()
    {
        $parameter = $this->getMockBuilder('\\Zend\\Mvc\\Controller\\Plugin\\Params')->getMock();

        $redirect = $this->getMockBuilder('\\Zend\Mvc\\Controller\\Plugin\\Redirect')->getMock();
        $repo = $this->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')->disableOriginalConstructor()->getMock();

        $this->getMockBuilder('\\DoctrineModule\\Paginator\\Adapter\\Selectable')->disableOriginalConstructor();

        $controller = $this->getMock($this->class, [
            'params',
            'fromRoute',
            'redirect',
            'toRoute'
        ], [
            $this->getMockAbstractModel(),
            $this->getMockFormHandle(),
            'default',
            'default',
            10
        ], '', true);

        $controller->expects($this->any())
            ->method('params')
            ->will($this->returnValue($parameter));

        $controller->expects($this->any())
            ->method('getParam')
            ->will($this->returnValue(null));

        $controller->expects($this->any())
            ->method('fromRoute')
            ->will($this->returnValue(null));

        $controller->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue($redirect));

        $controller->expects($this->any())
            ->method('toRoute')
            ->will($this->returnValue(null));

        $controller->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repo));

        return $controller;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockAbstractModel()
    {
        $repo = $this->getMockBuilder('\\Doctrine\\ORM\\EntityRepository')->disableOriginalConstructor()->getMock();

        $mock = $this->getMockForAbstractClass('\\Application\\Model\\AbstractModel', [
            $this->getMockEntityManager(), get_class($this->classExemple)
        ]);

        $mock->expects($this->any())
            ->method('save')
            ->with($this->equalTo($this->classExemple))
            ->will($this->returnValue($this->classExemple));

        $mock->expects($this->any())
            ->method('remove')
            ->with($this->equalTo(1))
            ->will($this->returnValue(null));

        $mock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repo));

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFormHandle()
    {
        $class = $this->getMockForAbstractClass('\\Application\\Form\\AbstractFormHandle', array(
            new AnnotationBuilder(),
            new ExempleEntity(),
            $this->getMockAbstractModel()
        ));

        return $class;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        return $this->getMockBuilder('\\Doctrine\\ORM\\EntityManager')->disableOriginalConstructor()->getMock();
    }
}
