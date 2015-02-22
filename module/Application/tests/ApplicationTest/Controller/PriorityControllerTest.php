<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCaseController;
use Application\Controller\PriorityController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Entity\Priority;

/**
 * Class PriorityControllerTest
 *
 * @package ApplicationTest\Controller
 */
class PriorityControllerTest extends TestCaseController
{
    use ApplicationMocks;

    protected $traceError = true;
    public $isORM = true;

    public function setupDB()
    {
        $priority = new Priority;
        $priority->setDescription('teste_priority')->setActive(true);
        $this->getEm()->persist($priority);

        $this->getEm()->flush();
    }

    private function controllerClass()
    {
        return new PriorityController(
            $this->getMockModel(),
            $this->getMockFormHandle(),
            'default',
            'default'
        );
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\PriorityController'));
        $this->assertInstanceOf('Application\\Controller\\AbstractController', $this->controllerClass());
    }

    public function testErro404()
    {
        $this->dispatch('/priority_error');
        $this->assertResponseStatusCode(404);
    }

    public function testIndexAction()
    {
        $this->setupDB();

        $this->dispatch('/priority');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Priority');
        $this->assertControllerClass('PriorityController');
        $this->assertMatchedRouteName('priority');

        // get and assert mvc event
        $mvcEvent = $this->getApplication()->getMvcEvent();
        $this->assertEquals(true, $mvcEvent instanceof MvcEvent);
        $this->assertEquals($mvcEvent->getApplication(), $this->getApplication());

        //get and assert view controller
        $viewModel = $mvcEvent->getResult();
        $this->assertEquals(true, $viewModel instanceof ViewModel);

        //test variable  viewmodel
        $var = $viewModel->getVariables();
        $this->assertArrayHasKey('data', $var);

        //test return, Paginator
        $this->assertInstanceOf('Zend\Paginator\Paginator', $var['data']);

        //test parameter response.
        foreach ($var['data'] as $value) {
            $this->assertEquals('teste_priority', $value->getDescription());
        }
    }

    public function testIndexActionRoutePagination()
    {
        $this->dispatch('/priority/page/1');
        $this->assertResponseStatusCode(200);
    }

    public function testNewAction()
    {
        $this->dispatch('/priority/new');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Priority');
        $this->assertControllerClass('PriorityController');
        $this->assertMatchedRouteName('priority');

        //get and assert mvc event
        $mvcEvent = $this->getApplication()->getMvcEvent();
        $this->assertEquals(true, $mvcEvent instanceof MvcEvent);
        $this->assertEquals($mvcEvent->getApplication(), $this->getApplication());

        //get and assert view controller
        $viewModel = $mvcEvent->getResult();
        $this->assertEquals(true, $viewModel instanceof ViewModel);

        //test variable  viewmodel
        $var = $viewModel->getVariables();
        $this->assertArrayHasKey('form', $var);

        //Chech if exeists Zend\Form in View
        $this->assertInstanceOf('Zend\\Form\\Form', $var['form']);
    }

    public function testMethodPostInNewAction()
    {
        $this->dispatch('/priority/new', Request::METHOD_POST, array(
                'description' => 'test_new_description',
        ));

        $entity = $this->getEm()->getRepository('Application\Entity\Priority')->find(1);
        $this->assertEquals('test_new_description', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/priority');
    }

    public function testEditAction()
    {
        $this->setupDB();

        $this->dispatch('/priority/edit/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Priority');
        $this->assertControllerClass('PriorityController');
        $this->assertMatchedRouteName('priority');

        //get and assert mvc event
        $mvcEvent = $this->getApplication()->getMvcEvent();
        $this->assertEquals(true, $mvcEvent instanceof MvcEvent);
        $this->assertEquals($mvcEvent->getApplication(), $this->getApplication());

        //get and assert view controller
        $viewModel = $mvcEvent->getResult();
        $this->assertEquals(true, $viewModel instanceof ViewModel);

        //test variable  viewmodel
        $var = $viewModel->getVariables();
        $this->assertArrayHasKey('form', $var);

        //Chech if exeists Zend\Form in View
        $this->assertInstanceOf('Zend\\Form\\Form', $var['form']);
    }

    public function testRedirectEditAction()
    {
        $this->setupDB();

        $this->dispatch('/priority/edit/19999999');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Priority');
        $this->assertControllerClass('PriorityController');
        $this->assertMatchedRouteName('priority');

        $this->assertRedirectTo('/priority');
    }

    public function testMethodPostInEditAction()
    {
        $this->setupDB();

        $this->dispatch('/priority/edit/1', Request::METHOD_POST, array(
            'description' => 'test_description_edit',
        ));

        $entity = $this->getEm()->getRepository('Application\\Entity\\Priority')->find(1);
        $this->assertEquals('test_description_edit', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/priority/edit/1');
    }

    public function testRedirectDeleteActionIfNotXmlHttpRequest()
    {
        $this->setupDB();

        $this->dispatch('/priority/delete/1');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/priority');
    }

    public function testDeleteAction()
    {
        $this->setupDB();

        $this->dispatch('/priority/delete/1', Request::METHOD_GET, array(), true);
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Priority');
        $this->assertControllerClass('PriorityController');
        $this->assertMatchedRouteName('priority');

        // get and assert mvc event
        $mvcEvent = $this->getApplication()->getMvcEvent();
        $this->assertEquals(true, $mvcEvent instanceof MvcEvent);
        $this->assertEquals($mvcEvent->getApplication(), $this->getApplication());

        // get and assert view controller
        $viewModel = $mvcEvent->getResult();
        $this->assertEquals(true, $viewModel instanceof JsonModel);

        //test variable in view
        $var = $viewModel->getVariables();

        $this->assertTrue($var[0]);

        $this->dispatch('/priority/delete/3', Request::METHOD_GET, array(), true);
        $mvcEvent = $this->getApplication()->getMvcEvent();

        // get and assert view controller
        $viewModel = $mvcEvent->getResult();

        //test variable in view
        $var = $viewModel->getVariables();
        $this->assertFalse($var[0]);

    }
}
