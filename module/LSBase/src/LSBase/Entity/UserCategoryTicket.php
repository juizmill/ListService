<?php

namespace LSBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCategoryTicket
 *
 * @ORM\Table(name="user_category_ticket")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSBase\Entity\Repository\UserCategoryRepository")
 */
class UserCategoryTicket
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
     * @var \CategoryTicket
     *
     * @ORM\ManyToOne(targetEntity="LSCategoryticket\Entity\CategoryTicket")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_ticket_id", referencedColumnName="id")
     * })
     */
    private $categoryTicket;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="LSUser\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set categoryTicket
     *
     * @param \LSCategoryticket\Entity\CategoryTicket $categoryTicket
     * @return UserCategoryTicket
     */
    public function setCategoryTicket(\LSCategoryticket\Entity\CategoryTicket $categoryTicket = null)
    {
        $this->categoryTicket = $categoryTicket;

        return $this;
    }

    /**
     * Get categoryTicket
     *
     * @return \LSCategoryticket\Entity\CategoryTicket 
     */
    public function getCategoryTicket()
    {
        return $this->categoryTicket;
    }

    /**
     * Set user
     *
     * @param \LSUser\Entity\User $user
     * @return UserCategoryTicket
     */
    public function setUser(\LSUser\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \LSUser\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
