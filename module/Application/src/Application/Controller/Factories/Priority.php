<?php

namespace Application\Controller\Factories;

use Application\Controller\PriorityController;
use Application\Form\Priority as PriorityForm;
use Application\Model\Priority as PriorityModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Priority
 *
 * @package Application\Controller\Factories
 */
class Priority implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!$serviceLocator->has('Doctrine\ORM\EntityManager')) {
            $entityManager = $serviceLocator->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        } else {
            $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        }

        $entity = '\\Application\\Entity\\Priority';
        $model = new PriorityModel($entityManager, $entity);

        $form = new PriorityForm(
            new AnnotationBuilder(),
            new $entity,
            $model
        );

        return new PriorityController(
            $model,
            $form,
            'priority',
            'priority'
        );
    }
}
