<?php
namespace LSCategoryticket\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * CategoryTicket
 *
 * Classe Service CategoryTicket
 *
 * @package LSCategoryticket\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class CategoryTicket extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSCategoryticket\Entity\CategoryTicket';
  }
}