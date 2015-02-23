<?php

namespace Application\Controller\Factories;

use Application\Controller\TicketController;
use Application\Form\Ticket as TicketForm;
use Application\Model\Ticket as TicketModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Ticket
 *
 * @package Application\Controller\Factories
 */
class Ticket implements FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Application\Controller\TicketController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!$serviceLocator->has('Doctrine\ORM\EntityManager')) {
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
