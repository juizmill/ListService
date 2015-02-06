<?php

namespace Application\Entity;

use ZfcUser\Entity\UserInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\Column(name="user_name", type="text", nullable=true)
     * @var string
     */
    private $user_name;

    /**
     * @ORM\Column(name="email", type="text", nullable=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="display_name", type="text", nullable=true)
     * @var string
     */
    private $display_name;

    /**
     * @ORM\Column(name="password", type="text", nullable=false)
     * @var datetime
     */
    private $password;

    /**
     * @ORM\Column(name="state", type="text", nullable=false)
     * @var datetime
     */
    private $state;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @var datetime
     */
    private $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @var datetime
     */
    private $updated_at;


    /**
     * get username
     *
     * @return string  username
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * set username
     *
     * @param string $nuser_name Return username
     */
    public function setUserName($user_name)
    {
        $this->userName = $user_name;
        return $this;
    }

    /**
     * get email
     *
     * @return string Return string email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set email
     *
     * @param String $email Return string email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * get display_name
     *
     * @return string return display name
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * set display_name
     *
     * @param string $display_name Return display name
     * @return $this
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
        return $this;
    }

    /**
     * get password
     *
     * @return string return password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * set password
     *
     * @param String $password  return password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * get state
     *
     * @return string Return state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * set state
     *
     * @param String $state Return state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * set created_at
     *
     * @return datetime date created
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * set created_at
     *
     * @param datetime $created_at Date created
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * get updated_at
     *
     * @return datetime date updated
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * set updated
     *
     * @param datetime $updated_at Date updated
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
