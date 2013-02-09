<?php

namespace LSUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand,
    Zend\Crypt\Key\Derivation\Pbkdf2,
    Zend\Stdlib\Hydrator;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSUser\Entity\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks 
 */
class User
{

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=80, nullable=false)
   */
  private $name;

  /**
   * @var string
   *
   * @ORM\Column(name="login", type="string", length=255, nullable=false)
   */
  private $login;

  /**
   * @var string
   *
   * @ORM\Column(name="password", type="string", length=255, nullable=false)
   */
  private $password;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date_registry", type="datetime", nullable=false)
   */
  private $dateRegistry;

  /**
   * @var boolean
   *
   * @ORM\Column(name="active", type="boolean", nullable=false)
   */
  private $active;

  /**
   * @var string
   *
   * @ORM\Column(name="salt", type="string", length=255, nullable=false)
   */
  private $salt;

  /**
   * @var \TypeUser
   *
   * @ORM\ManyToOne(targetEntity="LSTypeuser\Entity\TypeUser")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="type_use_id", referencedColumnName="id")
   * })
   */
  private $typeUse;

  /**
   * __construct
   * 
   * @param array $options
   */
  public function __construct(array $options = array())
  {
    $hydrator = new Hydrator\ClassMethods;
    $hydrator->hydrate($options, $this);

    $this->salt = base64_encode(Rand::getBytes(30, true));
    $this->active = true;
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return User
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string 
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set login
   *
   * @param string $login
   * @return User
   */
  public function setLogin($login)
  {
    $this->login = $login;

    return $this;
  }

  /**
   * Get login
   *
   * @return string 
   */
  public function getLogin()
  {
    return $this->login;
  }

  /**
   * Set password
   *
   * @param string $password
   * @return User
   */
  public function setPassword($password)
  {
    $this->password = $this->encryptPassword($password);

    return $this;
  }

  /**
   * Get password
   *
   * @return string 
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set dateRegistry
   *
   * @ORM\PrePersist
   * @param \DateTime $dateRegistry
   * @return User
   */
  public function setDateRegistry()
  {
    $this->dateRegistry = new \DateTime('now');

    return $this;
  }

  /**
   * Get dateRegistry
   *
   * @return \DateTime 
   */
  public function getDateRegistry()
  {
    return $this->dateRegistry;
  }

  /**
   * Set active
   *
   * @param boolean $active
   * @return User
   */
  public function setActive($active)
  {
    $this->active = $active;

    return $this;
  }

  /**
   * Get active
   *
   * @return boolean 
   */
  public function getActive()
  {
    return $this->active;
  }

  /**
   * Set salt
   *
   * @param string $salt
   * @return User
   */
  public function setSalt($salt)
  {
    $this->salt = $salt;

    return $this;
  }

  /**
   * Get salt
   *
   * @return string 
   */
  public function getSalt()
  {
    return $this->salt;
  }

  /**
   * Set typeUse
   *
   * @param \LSTypeuser\Entity\TypeUser $typeUse
   * @return User
   */
  public function setTypeUse(\LSTypeuser\Entity\TypeUser $typeUse = null)
  {
    $this->typeUse = $typeUse;

    return $this;
  }

  /**
   * Get typeUse
   *
   * @return \LSTypeuser\Entity\TypeUser 
   */
  public function getTypeUse()
  {
    return $this->typeUse;
  }

  /**
   * encryptLoginAndPassword
   * 
   * @param string $senhaOrPassword
   * @param integer $iterations
   * @return string hash
   */
  public function encryptPassword($password)
  {
    return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 15000, strlen($password * 2)));
  }

  /**
   * toArray
   * 
   * @return array
   */
  public function toArray()
  {
    $hydrator = new Hydrator\ClassMethods;
    return $hydrator->extract($this);
  }

}
