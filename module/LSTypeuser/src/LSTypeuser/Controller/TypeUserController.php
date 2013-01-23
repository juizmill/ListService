<?php

namespace LSTypeuser\Controller;

use LSBase\Controller\CrudController;

/**
 * TypeUserController
 *
 * Classe Controller TypeUserController
 *
 * @package LSTypeuser\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TypeUserController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'type-user';
    $this->entity = 'LSTypeuser\Entity\TypeUser';
    $this->form = 'LSTypeuser\Form\TypeUser';
    $this->service = 'LSTypeuser\Service\TypeUser';
    $this->route = 'typeuser';
  }
  
}