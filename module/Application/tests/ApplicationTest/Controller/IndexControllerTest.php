<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\TestCaseController;
use Application\Controller\IndexController;

/**
 * Class CategoryControllerTest
 * @package ApplicationTest\Controller
 */
class IndexControllerTest extends TestCaseController
{
    protected $traceError = true;

    public function testClasseExiste()
    {
        $this->assertTrue(class_exists('Application\\Controller\\IndexController'));
    }

    public function testMethodExist()
    {
        $this->assertTrue(method_exists('Application\\Controller\\IndexController', 'indexAction'));
    }

    public function testReturnMethodIndexAction()
    {
        $controller = new IndexController();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $controller->indexAction());
    }
}
