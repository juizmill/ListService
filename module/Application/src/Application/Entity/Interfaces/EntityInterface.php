<?php

namespace Application\Entity\Interfaces;

/**
 * Interface EntityInterface
 *
 * @package Application\Entity\Interfaces
 */
interface EntityInterface
{
    /**
     * @return integer
     */
    public function getIdentity();

    /**
     * @param $identity integer
     * @return $this
     */
    public function setIdentity($identity);

    /**
     * @return bool
     */
    public function isActive();

    /**
     * @param $active bool
     * @return bool
     */
    public function setActive($active);

    /**
     * @return array
     */
    public function toArray();
}
