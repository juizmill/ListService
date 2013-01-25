<?php

namespace LSCategoryticket\Controller;

use LSBase\Controller\CrudController;

/**
 * CategoryTicketController
 *
 * Classe Controller CategoryTicketController
 *
 * @package LSCategoryticket\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class CategoryTicketController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'category-ticket';
    $this->entity = 'LSCategoryticket\Entity\CategoryTicket';
    $this->form = 'LSCategoryticket\Form\CategoryTicket';
    $this->service = 'LSCategoryticket\Service\CategoryTicket';
    $this->route = 'category-ticket';
  }
  
}