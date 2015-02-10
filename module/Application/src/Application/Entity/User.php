<?php

namespace Application\Entity;

use ZfcUser\Entity\UserInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var $id integer
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="text", length=80, nullable=true)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="text", length=255, nullable=false)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="display_name", type="text", length=255, nullable=true)
     * @var string
     */
    private $display_name;

    /**
     * @ORM\Column(name="password", type="text", length=255, nullable=false)
     * @var datetime
     */
    private $password;

    /**
     * @ORM\Column(name="state", type="boolean", nullable=false, options={"default" = 0})
     * @var datetime
     */
    private $state;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @var datetime
     */
    private $created_at;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @var datetime
     */
    private $updated_at;

    /**
     * @ORM\Column(name="active_key", type="string", length=255, nullable=false)
     * @var $active_key string
     */
    private $active_key;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" = 1})
     * @var boolean
     */
    private $active = true;

    /**
     * construct
     */
    public function __construct(Array $options = [])
    {
        $this->setActiveKey(md5($this->email . date('Y-m-d H:m:s')));
        (new ClassMethods)->hydrate($options, $this);
    }

    /**
     * get id
     *
     * @return integer return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set id
     *
     * @param integer $id Return integer
     * @return $this;
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * get username
     *
     * @return string  username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * set username
     *
     * @param string $username Return username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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

    /**
     * @param string $active_key
     * @return $this
     */
    public function setActiveKey($active_key)
    {
        $this->active_key = $active_key;
        return $this;
    }

    /**
     * @return string active_key
     */
    public function getActiveKey()
    {
        return $this->active_key;
    }
    /**
     * get active
     *
     * @return boolean Return a boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * set active
     *
     * @param boolean $active Return a boolean
     * @return $this
     */
    public function setActive($active)
    {
        if (! is_bool($active)) {
            throw new \RuntimeException(__FUNCTION__.' accept only boolean');
        }

        $this->active = (boolean) $active;
        return $this;
    }

    /**
     * to array
     *
     * @return array Return array list
     */
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}
