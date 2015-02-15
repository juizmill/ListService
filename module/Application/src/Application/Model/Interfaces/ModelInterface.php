<?php

namespace Application\Model\Interfaces;

use Application\Entity\Interfaces\EntityInterface;

/**
 * Interface ModelInterface
 *
 * @package Application\Model\Interfaces
 */
interface ModelInterface
{
    /**
     * @param EntityInterface $entityInterface
     * @return EntityInterface
     */
    public function save(EntityInterface $entityInterface);

    /**
     * @param $identity
     * @return EntityInterface
     */
    public function remove($identity);

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository();

    /**
     * @param int $identity
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     * @throws \Doctrine\ORM\ORMException
     */
    public function getReference($identity);
}
