<?php

namespace Application\Model;

use Application\Entity\Interfaces\EntityInterface;
use Application\Model\Interfaces\ModelInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractModel
 *
 * @package Application\Model
 */
class AbstractModel implements ModelInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    protected $entity;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param                             $entity
     */
    public function __construct(EntityManager $entityManager, $entity)
    {
        if (null === $this->entityManager) {
            $this->entityManager = $entityManager;
        }

        $this->entity = $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function save(EntityInterface $entityInterface)
    {
        if (! is_null($entityInterface->getIdentity())) {
            $this->entityManager->merge($entityInterface);
        } else {
            $this->entityManager->persist($entityInterface);
        }

        $this->entityManager->flush($entityInterface);

        return $entityInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($identity)
    {
        $entity = $this->entityManager->getReference($this->entity, (int) $identity);

        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);

        return $entity;
    }
}
