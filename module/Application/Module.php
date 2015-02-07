<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Validator\NoObjectExists;
use Zend\Form\Factory;
use Zend\Form\Element\Button;
use Application\Entity\Category;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
                }
            )
        );
    }
}
