<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\TestCaseController;
use Application\Controller\CategoryController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Entity\Category;

/**
 * Class CategoryControllerTest
 * @package ApplicationTest\Controller
 */
class CategoryControllerTest extends TestCaseController
{
    protected $traceError = true;
    public $isORM = true;

    public function setupDB()
    {
        $category = new Category;
        $category->setDescription('teste_category')->setActive(true);
        $this->getEm()->persist($category);

        $this->getEm()->flush();
    }

    /**
     *
     */
    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\CategoryController'));
        $this->assertInstanceOf('Application\\Controller\\AbstractController', new CategoryController());
    }

    public function testConstructor()
    {
        $controller = new CategoryController();

        $this->assertEquals('Application\\Entity\\Category', $controller->entity);
        $this->assertEquals('category', $controller->controller);
        $this->assertEquals('category.form', $controller->form);
        $this->assertEquals('category', $controller->route);
    }

    public function testErro404()
    {
        $this->dispatch('/category_error');
        $this->assertResponseStatusCode(404);
    }

    public function testIndexAction()
    {
        $this->setupDB();

        $result = $this->dispatch('/category');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');

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
            $this->assertEquals('teste_category', $value->getDescription());
        }
    }

    public function testIndexActionRoutePagination()
    {
        $this->dispatch('/category/page/1');
        $this->assertResponseStatusCode(200);
    }

    public function testNewAction()
    {
        $this->dispatch('/category/new');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');

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
        $this->dispatch('/category/new', Request::METHOD_POST, array(
                'description' => 'test_new_description',
        ));

        $entity = $this->getEm()->getRepository('Application\Entity\Category')->find(1);
        $this->assertEquals('test_new_description', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/category');
    }

    public function testEditAction()
    {
        $this->setupDB();

        $this->dispatch('/category/edit/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');

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

        $this->dispatch('/category/edit/19999999');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');

        $this->assertRedirectTo('/category');
    }

    public function testMethodPostInEditAction()
    {
        $this->setupDB();

        $this->dispatch('/category/edit/1', Request::METHOD_POST, array(
            'description' => 'test_description_edit',
        ));

        $entity = $this->getEm()->getRepository('Application\\Entity\\Category')->find(1);
        $this->assertEquals('test_description_edit', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/category/edit/1');
    }

    public function testRedirectDeleteActionIfNotXmlHttpRequest()
    {
        $this->setupDB();

        $this->dispatch('/category/delete/1');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/category');
    }

    public function testDeleteAction()
    {
        $this->setupDB();

        $this->dispatch('/category/delete/1', Request::METHOD_GET, array(), true);
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');

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

        $this->dispatch('/category/delete/3', Request::METHOD_GET, array(), true);
        $mvcEvent = $this->getApplication()->getMvcEvent();

        // get and assert view controller
        $viewModel = $mvcEvent->getResult();

        //test variable in view
        $var = $viewModel->getVariables();
        $this->assertFalse($var[0]);

    }
}
