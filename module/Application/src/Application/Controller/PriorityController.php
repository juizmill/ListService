<?php

namespace Application\Controller;

/**
 * Class PriorityController
 *
 * @package Application\Controller
 */
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
