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
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\Column(name="user_name", type="text", length=80, nullable=false)
     * @var string
     */
    private $user_name;

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
    private $state = false;

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
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     * @var $salt string
     */
    protected $salt;

    /**
     * @ORM\Column(name="active_key", type="string", length=255, nullable=false)
     * @var $active_key string
     */
    protected $active_key;

    /**
     * construct
     */
    public function __construct(Array $options = [])
    {
        $this->setSalt(Rand::getString(35, $this->email, true));
        $this->setActiveKey(md5($this->email . $this->salt . date('Y-m-d H:m:s')));
        parent::__construct($options);
    }

    /**
     * get username
     *
     * @return string  username
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * set username
     *
     * @param string $user_name Return username
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
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
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setSalt($this->salt);

        return $bcrypt->create($password);
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
        $this->password = $this->encryptPassword($password);
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
        if (! is_bool($state)) {
            throw new \RuntimeException(__FUNCTION__.' accept only boolean');
        }
        $this->state = (boolean) $state;
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
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return string return string salt
     */
    public function getSalt()
    {
        return $this->salt;
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
}
