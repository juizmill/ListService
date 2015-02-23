<?php

namespace Application\Controller\Factories;

use Application\Controller\CategoryController;
use Application\Form\Category as CategoryForm;
use Application\Model\Category as CategoryModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Category
 *
 * @package Application\Controller\Factories
 */
class Category implements FactoryInterface
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

        $entity = '\\Application\\Entity\\Category';
        $model = new CategoryModel($entityManager, $entity);

        $form = new CategoryForm(
            new AnnotationBuilder(),
            new $entity,
            $model
        );

        return new CategoryController(
            $model,
            $form,
            'category',
            'category'
        );
    }
}
