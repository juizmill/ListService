<?php
namespace LSTypeuser\Entity;

use LSBase\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeUser
 * @package LSTypeuser\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="type_user")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="LSTypeuser\Entity\Repository\TypeUserRepository")
 */
class TypeUser extends AbstractEntity
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var $id integer
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     * @var $name string
     */
    private $name;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        if (! is_numeric($id))
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
        if (strlen($name) > 30)
            throw new \InvalidArgumentException('NAME aceita apenas 30 caracteres');

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
}