<?php

namespace LSPriority\Controller;

use LSBase\Controller\CrudController;

/**
 * PriorityController
 *
 * Classe Controller PriorityController
 *
 * @package LSPriority\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class PriorityController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'priority';
    $this->entity = 'LSPriority\Entity\Priority';
    $this->form = 'LSPriority\Form\Priority';
    $this->service = 'LSPriority\Service\Priority';
    $this->route = 'priority';
  }
  
}