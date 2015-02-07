<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class PriorityController extends AbstractController
{
    public function __construct()
    {
        $this->entity = 'Application\\Entity\\Priority';
        $this->controller = 'priority';
        $this->form = 'priority.form';
        $this->route = 'priority';
    }
}
