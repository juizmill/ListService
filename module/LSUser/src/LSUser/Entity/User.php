<?php
namespace LSUser\Entity;

use LSBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;

/**
 * Class User
 * @package Usuario\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="LSUser\Entity\Repository\UserRepository")
 */
class User extends AbstractEntity
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var $id integer
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     * @var $name string
     */
    private $name;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @var $email string
     */
    private $email;

    /**
     * @ORM\Column(name="login", type="string", length=255, nullable=false, unique=true)
     * @var $login
     */
    private $login;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @var $password string
     */
    private $password;

    /**
     * @ORM\Column(name="registry", type="datetime", nullable=false)
     * @var $registry \DateTime
     */
    private $registry;

    /**
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     * @var $avatar string
     */
    private $avatar;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false)
     * @var $active boolean
     */
    private $active;

    /**
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     * @var $salt string
     */
    private $salt;

    /**
     * @ORM\Column(name="active_key", type="string", length=255, nullable=false)
     * @var $active_key string
     */
    private $active_key;

    /**
     * @ORM\ManyToOne(targetEntity="LSTypeuser\Entity\TypeUser")
     * @ORM\JoinColumn(name="type_user", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @var $type_user
     */
    private $type_user;

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        $this->salt = Rand::getString(35, $this->email, true);
        $this->active_key = md5($this->email . $this->salt);

        parent::__construct($options);
    }

    /**
     * @param $id
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setId($id)
    {
        if (!is_numeric($id))
            throw new \InvalidArgumentException('ID aceita apenas números inteiros');

        if ($id <= 0)
            throw new \InvalidArgumentException('ID aceita apenas números maiores que zero');

        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        if (strlen($name) > 80)
            throw new \InvalidArgumentException('NAME aceita apenas 80 caracteres');

        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if (strlen($email) > 255)
            throw new \InvalidArgumentException('EMAIL aceita apenas 255 caracteres');

        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        if (strlen($login) > 255)
            throw new \InvalidArgumentException('LOGIN aceita apenas 255 caracteres');

        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
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
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if (strlen($password) > 255)
            throw new \InvalidArgumentException('PASSWORD aceita apenas 255 caracteres');

        $this->password = $this->encryptPassword($password);;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $registry
     *
     */
    public function setRegistry($registry)
    {
        if (is_null($registry))
            $registry = new \DateTime('now');

        if (!$registry instanceof \DateTime)
            throw new \InvalidArgumentException('REGISTRY aceita apenas DATETIME');

        $this->registry = $registry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        if (strlen($avatar) > 255)
            throw new \InvalidArgumentException('AVATAR aceita apenas 255 caracteres');

        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        if (!is_bool($active))
            throw new \InvalidArgumentException('ACTIVE aceita apenas booleanos');

        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        if (strlen($salt) > 255)
            throw new \InvalidArgumentException('SALT aceita apenas 255 caracteres');

        $this->salt = $salt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $active_key
     */
    public function setActiveKey($active_key)
    {
        if (strlen($active_key) > 255)
            throw new \InvalidArgumentException('ACTIVEKEY aceita apenas 255 caracteres');

        $this->active_key = $active_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveKey()
    {
        return $this->active_key;
    }

    /**
     * @param mixed $type_user
     */
    public function setTypeUser(\LSTypeuser\Entity\TypeUser $type_user)
    {
        $this->type_user = $type_user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeUser()
    {
        return $this->type_user;
    }
}