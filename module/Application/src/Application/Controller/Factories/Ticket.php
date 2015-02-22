<?php

namespace Application\Controller\Factories;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\TicketController;
use Application\Model\Ticket as TicketModel;
use Application\Form\Ticket as TicketForm;

/**
 * Class Ticket
 *
 * @package Application\Controller\Factories
 */
class Ticket implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (! $serviceLocator->has('Doctrine\ORM\EntityManager')) {
            $entityManager = $serviceLocator->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        } else {
            $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        }

        $entity = '\\Application\\Entity\\Ticket';
        $model = new TicketModel($entityManager, $entity);

        $form = new TicketForm(
            new AnnotationBuilder(),
            new $entity,
            $model
        );

        return new TicketController(
            $model,
            $form,
            'ticket',
            'ticket'
        );
    }
}
