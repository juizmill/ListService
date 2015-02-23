<?php

namespace Application\Entity\Traits;

use Application\Entity\User as UserApp;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class ManyToOneUserTrait
 *
 * @ORM\Entity
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @package Application\Entity\Traits
 */
trait ManyToOneUserTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var $user \Application\Entity\User
     */
    private $user;

    /**
     * @return UserApp
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param  UserApp $user
     * @return $this
     */
    public function setUser(UserApp $user)
    {
        $this->user = $user;

        return $this;
    }
}
