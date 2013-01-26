<?php

namespace LSTicket\Form;

use Zend\Form\Form;

/**
 * From Ticket
 *
 * Camada de controle do formulário Ticket
 *
 * @package LSTicket\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Ticket extends Form
{

    public function __construct()
    {
        parent::__construct('ticket', array());

        $this->setInputFilter(new TicketFilter());
        $this->setAttribute('method', 'post');

        //Input Titulo
        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Titulo'
            ),
            'attributes' => array(
                'id' => 'title',
            )
        ));

        //Input ID
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        //Input Submit
        $this->add(array(
            'name' => 'salval',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
            )
        ));
    }

}
