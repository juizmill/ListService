<?php

namespace LSRelatorio\Controller;

use Zend\View\Model\ViewModel;
use LSBase\Controller\CrudController;

/**
 * RelatorioController
 *
 * Classe Controller RelatorioController
 *
 * @package LSRelatrio\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class RelatorioController extends CrudController
{

    public function __construct ()
    {
        $this->controller = 'relatorio';
        $this->route = 'relatorio';

    }

    /**
     * indexAction
     *
     * Exibe pagina principal.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $TicketOpen = $this->getEm()->getRepository('LSTicket\Entity\Ticket')->TotalTicketOpen();
        $TicketResolved = $this->getEm()->getRepository('LSTicket\Entity\Ticket')->TotalTicketResolved();
        $TicketOngoing = $this->getEm()->getRepository('LSTicket\Entity\Ticket')->TotalTicketOngoing();

        return new ViewModel(array('ticketOpen' => $TicketOpen[0][1], 'ticketResolved' => $TicketResolved[0][1], 'ticketOngoing' => $TicketOngoing[0][1]));

    }
}