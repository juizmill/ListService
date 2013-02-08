<?php

namespace LSInteraction\Controller;

use LSBase\Controller\CrudController;

/**
 * InteractionController
 *
 * Classe Controller InteractionController
 *
 * @package LSInteraction\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class InteractionController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'interaction';
    $this->entity = 'LSInteraction\Entity\Interaction';
    $this->form = 'LSInteraction\Form\Interaction';
    $this->service = 'LSInteraction\Service\Interaction';
    $this->route = 'interaction';
  }
  
}