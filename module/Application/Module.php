<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Helpers\ContentHeader;
use Application\Controller\CategoryController;

use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Validator\NoObjectExists;
use Zend\Form\Factory;
use Zend\Form\Element\Button;
use Application\Entity\Category;
use Application\Entity\Priority;
use Application\Entity\Ticket;
use Application\Entity\Interaction;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sharedEvents = $eventManager->getSharedManager();

        $sharedEvents->attach('Application\Controller\CategoryController', 'dispatch', function($e) {
            $sm = $e->getApplication()->getServiceManager();
            $translate = $sm->get('viewhelpermanager')->get('translate');
            $placeholder = $sm->get('viewhelpermanager')->get('placeholder');
            $placeholder->getContainer('contentHeader')->set('<h1>'.$translate('Category').'<small>'.$translate('Content category').'</small></h1>');
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
                'category.form' => function($sm) {
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
                'priority.form' => function($sm) {
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
                'interaction.form' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Interaction());

                    return $form;
                },
                'ticket.form' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $builder = new AnnotationBuilder();
                    $builder->setFormFactory(new Factory($sm->get('FormElementManager')));
                    $form = $builder->createForm(new Ticket());

                    return $form;
                }
            )
        );
    }
}
