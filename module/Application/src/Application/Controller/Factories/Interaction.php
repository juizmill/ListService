<?php

namespace Application\Controller\Factories;

use Application\Controller\InteractionController;
use Application\Form\Interaction as InteractionForm;
use Application\Model\Interaction as InteractionModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Interaction
 *
 * @package Application\Controller\Factories
 */
class Interaction implements FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Application\Controller\InteractionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!$serviceLocator->has('Doctrine\ORM\EntityManager')) {
            $entityManager = $serviceLocator->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        } else {
            $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        }

        $entity = '\\Application\\Entity\\Interaction';
        $model = new InteractionModel($entityManager, $entity);

        $form = new InteractionForm(
            new AnnotationBuilder(),
            new $entity,
            $model
        );

        return new InteractionController(
            $model,
            $form,
            'interaction',
            'interaction'
        );
    }
}
