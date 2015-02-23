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
     * @param EntityManager $entityManager
     * @param string        $entity
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
        if (!is_null($entityInterface->getIdentity())) {
            $this->entityManager->merge($entityInterface);
        } else {
            $this->entityManager->persist($entityInterface);
        }

        $this->entityManager->flush();

        return $entityInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($identity)
    {
        $entity = $this->getReference($identity);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository($this->entity);
    }

    /**
     * {@inheritdoc}
     */
    public function getReference($identity)
    {
        return $this->entityManager->getReference($this->entity, $identity);
    }
}
