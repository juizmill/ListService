<?php

namespace Application\Controller;

class TicketController extends AbstractController
{
    public function __construct()
    {
        $this->entity = 'Application\\Entity\\Ticket';
        $this->controller = 'ticket';
        $this->form = 'ticket.form';
        $this->route = 'ticket';
    }
}
