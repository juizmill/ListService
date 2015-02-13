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
     * @param $isActive bool
     * @return $this
     */
    public function setActive($isActive);

    /**
     * @return array
     */
    public function toArray();
}
