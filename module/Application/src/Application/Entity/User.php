<?php

namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfcUser\Entity\UserInterface;

/**
 * Class User
 *
 * @package Application\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\Column(name="username", type="text", length=80, nullable=true)
     * @var $username string
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="text", length=255, nullable=false)
     * @var $email string
     */
    private $email;

    /**
     * @ORM\Column(name="display_name", type="text", length=255, nullable=true)
     * @var $displayName string
     */
    private $displayName;

    /**
     * @ORM\Column(name="password", type="text", length=255, nullable=false)
     * @var $password string
     */
    private $password;

    /**
     * @ORM\Column(name="state", type="integer", nullable=true)
     * @var $state int
     */
    private $state;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @var $created_at datetime
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @var $updated_at datetime
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="active_key", type="string", length=255, nullable=false)
     * @var $active_key string
     */
    private $activeKey;

    /**
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        parent::__construct($options);
        $this->setActiveKey(md5($this->email.date('Y-m-d H:m:s')));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identity;
    }

    /**
     * @param  int $identity
     * @return $this
     */
    public function setId($identity)
    {
        $this->identity = $identity;

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
     * @param  string $username
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
     * @param  string $email
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
        return $this->displayName;
    }

    /**
     * @param  string $displayName
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

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
     * @param  string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param  int $state
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
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param $activeKey
     * @return $this
     */
    public function setActiveKey($activeKey)
    {
        $this->activeKey = $activeKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getActiveKey()
    {
        return $this->activeKey;
    }
}
