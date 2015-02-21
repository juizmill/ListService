<?php

namespace Application;

use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Validator\NoObjectExists;
use Zend\Form\Factory;
use Application\Entity\Category;
use Application\Entity\Priority;
use Application\Entity\Ticket;
use Application\Entity\Interaction;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Application\Model\Category as CategoryModel;
use Application\Controller\CategoryController;
use Application\Form\Category as CategoryForm;


/**
 * Class Module
 *
 * @package Application
 * @SuppressWarnings(PHPMD)
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /**
         * @var $sharedEvents \Zend\EventManager\SharedEventManager
         */
        $sharedEvents = $eventManager->getSharedManager();

        //edit template login
        $sharedEvents->attach(
            'ZfcUser\Controller\UserController',
            MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $event) {

                $routeMatch = $event->getRouteMatch();
                $viewModel = $event->getResult();

                if (($viewModel instanceof \Zend\View\Model\ViewModel) and
                    ($routeMatch->getParam('action') == 'login') or
                    ($routeMatch->getParam('action') == 'register')
                ) {
                    $viewModel->setTerminal(true);
                }

                $sm = $event->getApplication()->getServiceManager();
                $translate = $sm->get('viewhelpermanager')->get('translate');
                $placeholder = $sm->get('viewhelpermanager')->get('placeholder');
                $placeholder->getContainer('contentHeader')->set(
                    '<h1>'.$translate('User').'<small>'.$translate('Control panel').'</small></h1>'
                );
            },
            -99
        );

        //Add content header in pages.
        $sharedEvents->attach('Application\Controller\CategoryController', 'dispatch', function ($e) {
            $sm = $e->getApplication()->getServiceManager();
            $translate = $sm->get('viewhelpermanager')->get('translate');
            $placeholder = $sm->get('viewhelpermanager')->get('placeholder');
            $placeholder->getContainer('contentHeader')->set(
                '<h1>'.$translate('Category').'<small>'.$translate('Content category').'</small></h1>'
            );
        }, 99);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
           'invokables' => array(
               'contentHeader' => 'Application\Helpers\ContentHeader',
           ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'category.form' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Category());

                    //Check field description
                    $form->getInputFilter()->get('description')->getValidatorChain()->attach(new NoObjectExists(array(
                        'object_repository' =>  $em->getRepository('Application\Entity\Category'),
                        'fields' => array('description'),
                        'messages' => array('objectFound' => 'Description exists')
                    )));

                    return $form;
                },
                'priority.form' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Priority());

                    //Check field description
                    $form->getInputFilter()->get('description')->getValidatorChain()->attach(new NoObjectExists(array(
                        'object_repository' =>  $em->getRepository('Application\Entity\Priority'),
                        'fields' => array('description'),
                        'messages' => array('objectFound' => 'Description exists')
                    )));

                    return $form;
                },
                'interaction.form' => function ($sm) {
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Interaction());

                    return $form;
                },
                'ticket.form' => function ($sm) {
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Ticket());

                    return $form;
                }
            )
        );
    }

//    /**
//     * @return array
//     */
//    public function getControllerConfig()
//    {
//        return [
//            'factories' => [
//                'Application\\Controller\\CategoryController' => function ($sm) {
//                    $entityManager = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//                    $entity = '\\Application\\Entity\\Category';
//
//                    $model = new CategoryModel($entityManager, $entity);
//
//                    $form = new CategoryForm(
//                        new AnnotationBuilder(),
//                        new $entity,
//                        $model
//                    );
//
//                    return new CategoryController(
//                        $model,
//                        $form,
//                        'category',
//                        'category'
//                    );
//                }
//            ]
//        ];
//    }
}
