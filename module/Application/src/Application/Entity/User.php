<?php

namespace Application\Entity;

use DateTime;
use ZfcUser\Entity\UserInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Application\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @SuppressWarnings(PHPMD)
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
     * @var boolean
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
     * @var string
     */
    private $active_key;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" = 1})
     * @var boolean
     */
    private $active = true;

    /**
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        $this->setActiveKey(md5($this->email . date('Y-m-d H:m:s')));
        (new ClassMethods)->hydrate($options, $this);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     * @return $this
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @param $active_key
     * @return $this
     */
    public function setActiveKey($active_key)
    {
        $this->active_key = $active_key;

        return $this;
    }

    /**
     * @return string
     */
    public function getActiveKey()
    {
        return $this->active_key;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param $active
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
     * @return array
     */
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}
