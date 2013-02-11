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
    protected $typeTicket;

    public function __construct(array $typeTicket = array())
    {

        $this->typeTicket = array_keys($typeTicket);

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

        /**
         * Validando o campo Solicitante
         */
        $this->add(array(
            'name' => 'sought',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Solicitante não pode estar em branco')))
            )
        ));

        //Validando campo select
        $this->add(array(
            'name' => 'categoryTicket',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => $this->typeTicket,
                        'messages' => array(
                            'notInArray' => 'Selecione uma categoria!'
                        ),
                    ),
                ),
            ),
        ));

        /**
         * Validando o campo Solicitante
         */
        $this->add(array(
            'name' => 'description',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Descrição não pode estar em branco')))
            )
        ));

    }

}