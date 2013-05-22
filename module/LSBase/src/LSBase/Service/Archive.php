<?php
namespace LSBase\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * Archive
 *
 * Classe Service Archive
 *
 * @package LSArchive\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Archive extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSBase\Entity\Archive';
  }
}