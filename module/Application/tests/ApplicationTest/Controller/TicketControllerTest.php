<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Framework\TestCaseController;
use Application\Controller\TicketController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Entity\Ticket;
use Application\Entity\User;

/**
 * Class TicketControllerTest
 * @package ApplicationTest\Controller
 */
class TicketControllerTest extends TestCaseController
{
    protected $traceError = true;
    public $isORM = true;


    public function creatadUser()
    {
        $user = new User;
        $user->setEmail('teste@gmail.com')
            ->setUserName('teste')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name')
            ->setDescription('description_test');
        $this->getEm()->persist($user);
        $this->getEm()->flush();
    }

    public function setupDB()
    {
        $this->creatadUser();
        $user = $this->getEm()->getRepository('Application\Entity\User')->find(1);

        $this->creatadUser();
        $ticket = new Ticket;
        $ticket->setTitle('teste_ticket')
            ->setSought('test_sought')
            ->setUser($user);
        $this->getEm()->persist($ticket);

        $this->getEm()->flush();
    }

    /**
     *
     */
    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\TicketController'));
        $this->assertInstanceOf('Application\\Controller\\AbstractController', new TicketController());
    }

    public function testConstructor()
    {
        $controller = new TicketController();

        $this->assertEquals('Application\\Entity\\Ticket', $controller->entity);
        $this->assertEquals('ticket', $controller->controller);
        $this->assertEquals('ticket.form', $controller->form);
        $this->assertEquals('ticket', $controller->route);
    }

    public function testErro404()
    {
        $this->dispatch('/ticket_error');
        $this->assertResponseStatusCode(404);
    }

    public function testIndexAction()
    {
        $this->setupDB();

        $result = $this->dispatch('/ticket');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Ticket');
        $this->assertControllerClass('TicketController');
        $this->assertMatchedRouteName('ticket');

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
            $this->assertEquals('teste_ticket', $value->getTitle());
        }
    }

    public function testIndexActionRoutePagination()
    {
        $this->dispatch('/ticket/page/1');
        $this->assertResponseStatusCode(200);
    }

    public function testNewAction()
    {
        $this->dispatch('/ticket/new');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Ticket');
        $this->assertControllerClass('TicketController');
        $this->assertMatchedRouteName('ticket');

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
        $this->creatadUser();
        $user = $this->getEm()->getRepository('Application\Entity\User')->find(1);

        $this->dispatch('/ticket/new', Request::METHOD_POST, array(
                'title' => 'test_new_title',
                'sought' => 'test_sought',
                'user' => $user
        ));

        $entity = $this->getEm()->getRepository('Application\Entity\Ticket')->find(1);
        $this->assertEquals('test_new_title', $entity->getTitle());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/ticket');
    }

    public function testEditAction()
    {
        $this->setupDB();

        $this->dispatch('/ticket/edit/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Ticket');
        $this->assertControllerClass('TicketController');
        $this->assertMatchedRouteName('ticket');

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

        $this->dispatch('/ticket/edit/19999999');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Ticket');
        $this->assertControllerClass('TicketController');
        $this->assertMatchedRouteName('ticket');

        $this->assertRedirectTo('/ticket');
    }

    public function testMethodPostInEditAction()
    {
        $this->setupDB();

        $user = $this->getEm()->getRepository('Application\Entity\User')->find(1);
        $this->dispatch('/ticket/edit/1', Request::METHOD_POST, array(
            'title' => 'test_title_edit',
            'sought' => 'test_sought_edit'
        ));

        $entity = $this->getEm()->getRepository('Application\\Entity\\Ticket')->find(1);

        $this->assertEquals('test_title_edit', $entity->getTitle());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/ticket/edit/1');
    }

    public function testRedirectDeleteActionIfNotXmlHttpRequest()
    {
        $this->setupDB();

        $this->dispatch('/ticket/delete/1');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/ticket');
    }

    public function testDeleteAction()
    {
        $this->setupDB();

        $this->dispatch('/ticket/delete/1', Request::METHOD_GET, array(), true);
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Ticket');
        $this->assertControllerClass('TicketController');
        $this->assertMatchedRouteName('ticket');

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

        $this->dispatch('/ticket/delete/3', Request::METHOD_GET, array(), true);
        $mvcEvent = $this->getApplication()->getMvcEvent();

        // get and assert view controller
        $viewModel = $mvcEvent->getResult();

        //test variable in view
        $var = $viewModel->getVariables();
        $this->assertFalse($var[0]);

    }
}
