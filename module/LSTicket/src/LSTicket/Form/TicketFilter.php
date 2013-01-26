<?php

namespace LSTicket\Form;

use Zend\InputFilter\InputFilter;

/**
 * Validação TicketFilter
 *
 * Camada de controle de validação do formulário Ticket
 *
 * @package LSTicke\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TicketFilter extends InputFilter
{

    public function __construct()
    {

        /**
         * Validando o campo Nome
         */
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Titulo não pode estar em branco')))
            )
        ));
        
    }

}