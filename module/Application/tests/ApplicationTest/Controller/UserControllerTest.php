<?php

namespace ApplicationTest\Controller;

use Application\Controller\UserController;
use Application\Entity\User;
use ApplicationTest\Framework\TestCaseController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * Class UserControllerTest
 *
 * @package ApplicationTest\Controller
 */
class UserControllerTest extends TestCaseController
{
    protected $traceError = true;
    public $isORM = true;

    public function setUp()
    {
        parent::setUp();
        $user = new User;
        $user->setEmail('teste@gmail.com')
            ->setUserName('teste')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name')
            ->setState(true);
        $this->getEm()->persist($user);
        $this->getEm()->flush();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Controller\\UserController'));
        $this->assertInstanceOf('Zend\\Mvc\\Controller\\AbstractActionController', new UserController());
    }

    public function testIndexAction()
    {
        $this->dispatch('/user/recovery-password');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\controller\User');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user');

        // get and assert mvc event
        $mvcEvent = $this->getApplication()->getMvcEvent();
        $this->assertEquals(true, $mvcEvent instanceof MvcEvent);
        $this->assertEquals($mvcEvent->getApplication(), $this->getApplication());

        //get and assert view controller
        $viewModel = $mvcEvent->getResult();
        $this->assertEquals(true, $viewModel instanceof ViewModel);

        //test variable  viewmodel
        $var = $viewModel->getVariables();
        $this->assertArrayHasKey('form', $var);

        //test return, Paginator
        $this->assertInstanceOf('Zend\Form\Form', $var['form']);
    }

    public function testErrorPostInRecoveryPasswordAction()
    {
        $this->dispatch('/user/recovery-password', Request::METHOD_POST, array(
                'email' => 'return error',
        ));

        $this->assertResponseStatusCode(200);

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertResponseStatusCode(200);
    }

    public function testErrorPostInRecoveryPasswordActionIfEmailNotFound()
    {
        $this->dispatch('/user/recovery-password', Request::METHOD_POST, array(
            'email' => 'teste@google.com',
        ));

        $this->assertResponseStatusCode(302);

        $request = $this->getRequest();
        $this->assertEquals($request->getMethod(), Request::METHOD_POST);

        $this->assertRedirectTo('/user/recovery-password');
    }
}
