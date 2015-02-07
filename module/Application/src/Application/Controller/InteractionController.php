<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class InteractionController extends AbstractController
{
    public function __construct()
    {
        $this->entity = 'Application\\Entity\\Interaction';
        $this->controller = 'interaction';
        $this->form = 'interaction.form';
        $this->route = 'interaction';
    }
}
