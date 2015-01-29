<?php
/**
 * WebPatterns (http://webpatterns.com.br/)
 *
 * @copyright Copyright (c) 2014-2014. (http://www.webpatterns.com.br)
 * @license   http://webpatterns.com.br/license
 */

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
