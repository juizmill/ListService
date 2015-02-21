<?php

namespace ApplicationTest\Controller;

use Application\Entity\Ticket;
use Application\Entity\User;
use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCaseController;
use Application\Controller\InteractionController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Entity\Interaction;

/**
 * Class InteractionControllerTest
 *
 * @package ApplicationTest\Controller
 */
class InteractionControllerTest extends TestCaseController
{
    use ApplicationMocks;

    protected $traceError = true;
    public $isORM = true;

    public function setupDB()
    {
        $user = new User;
        $user->setEmail('teste@gmail.com')
            ->setUserName('teste')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name')
            ->setState(true);
        $this->getEm()->persist($user);
        $this->getEm()->flush();

        $ticket = new Ticket;
        $ticket->setTitle('teste_ticket')
            ->setSought('test_sought')
            ->setUser($user);
        $this->getEm()->persist($ticket);
        $this->getEm()->flush();

        $interaction = new Interaction;
        $interaction->setDescription('teste_interaction')
            ->setUser($user)
            ->setTicket($ticket);
        $this->getEm()->persist($interaction);

        $this->getEm()->flush();
    }

    private function controllerClass()
    {
        return new InteractionController(
            $this->getMockModel(),
            $this->getMockFormHandle(),
            'default',
            'default'
        );
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\InteractionController'));
        $this->assertInstanceOf('Application\\Controller\\AbstractController', $this->controllerClass());
    }

    public function testErro404()
    {
        $this->dispatch('/interaction_error');
        $this->assertResponseStatusCode(404);
    }

    public function testIndexAction()
    {
        $this->setupDB();

        $this->dispatch('/interaction');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Interaction');
        $this->assertControllerClass('InteractionController');
        $this->assertMatchedRouteName('interaction');

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
            $this->assertEquals('teste_interaction', $value->getDescription());
        }
    }

    public function testIndexActionRoutePagination()
    {
        $this->dispatch('/interaction/page/1');
        $this->assertResponseStatusCode(200);
    }

    public function testNewAction()
    {
        $this->dispatch('/interaction/new');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Interaction');
        $this->assertControllerClass('InteractionController');
        $this->assertMatchedRouteName('interaction');

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
        $this->dispatch('/interaction/new', Request::METHOD_POST, array(
                'description' => 'test_new_description',
        ));

        $entity = $this->getEm()->getRepository('Application\Entity\Interaction')->find(1);
        $this->assertEquals('test_new_description', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/interaction');
    }

    public function testEditAction()
    {
        $this->setupDB();

        $this->dispatch('/interaction/edit/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Interaction');
        $this->assertControllerClass('InteractionController');
        $this->assertMatchedRouteName('interaction');

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

        $this->dispatch('/interaction/edit/19999999');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Interaction');
        $this->assertControllerClass('InteractionController');
        $this->assertMatchedRouteName('interaction');

        $this->assertRedirectTo('/interaction');
    }

    public function testMethodPostInEditAction()
    {
        $this->setupDB();


        $this->dispatch('/interaction/edit/1', Request::METHOD_POST, array(
            'description' => 'test_description_edit',
        ));



        $entity = $this->getEm()->getRepository('Application\Entity\Interaction')->find(1);
        $this->assertEquals('test_description_edit', $entity->getDescription());

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/interaction/edit/1');
    }

    public function testRedirectDeleteActionIfNotXmlHttpRequest()
    {
        $this->setupDB();

        $this->dispatch('/interaction/delete/1');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/interaction');
    }

    public function testDeleteAction()
    {
        $this->setupDB();

        $this->dispatch('/interaction/delete/1', Request::METHOD_GET, array(), true);
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\Interaction');
        $this->assertControllerClass('InteractionController');
        $this->assertMatchedRouteName('interaction');

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

        $this->dispatch('/interaction/delete/3', Request::METHOD_GET, array(), true);
        $mvcEvent = $this->getApplication()->getMvcEvent();

        // get and assert view controller
        $viewModel = $mvcEvent->getResult();

        //test variable in view
        $var = $viewModel->getVariables();
        $this->assertFalse($var[0]);

    }
}
