<?php

namespace LSUser\Controller;

use LSBase\Controller\CrudController;

/**
 * UserController
 *
 * Classe Controller UserController
 *
 * @package LSUser\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class UserController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'user';
    $this->entity = 'LSUser\Entity\User';
    $this->form = 'LSUser\Form\User';
    $this->service = 'LSUser\Service\User';
    $this->route = 'user';
  }
  
}