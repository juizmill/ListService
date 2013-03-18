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
        return new ViewModel();

    }
}