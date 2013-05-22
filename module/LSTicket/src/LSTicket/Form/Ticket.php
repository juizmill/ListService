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
    protected $typeTicket;

    public function __construct(array $typeTicket = array())
    {
        parent::__construct('ticket', array());

        $this->typeTicket = $typeTicket;

        $this->setInputFilter(new TicketFilter($this->typeTicket));
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
                'maxlenght' => 60,
                'class' => 'input-xlarge',
            )
        ));

        //Input Solicitante
        $this->add(array(
            'name' => 'sought',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Solicitante'
            ),
            'attributes' => array(
                'id' => 'sought',
                'maxlenght' => 45,
                'class' => 'input-xlarge',
            )
        ));

        //Select categoria de ticket
        $this->add (array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'categoryTicket',
            'options' => array(
                'label' => 'Categoria',
                'value_options' => $this->typeTicketSelect(),
            ),
            'attributes' => array(
                'value' => '0',
                'id' => 'categoryTicket',
                'class' => 'input-xlarge',
            ),
        ));

        //Input Descricao
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Descrição'
            ),
            'attributes' => array(
                'id' => 'description',
                'class' => 'input-xlarge',
                'rows' => 8,
            )
        ));

        //Input Descricao
        $this->add(array(
            'name' => 'archive',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Anexo'
            ),
            'attributes' => array(
                'id' => 'archive',
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
                'class' => 'btn btn-success btn-large',
            )
        ));
    }

    /**
     * typeTicketSelect
     *
     * Faz o tratamento dos tipos de usuarios que vem no formato de array
     * adiciona no primeiro índice do array o "--Selecione--"
     * e retorna o array com todos os tipos de usuarios mais o "--Selecione--"
     *
     * @return array
     */
    protected function typeTicketSelect ()
    {
        $keys = array_keys ($this->typeTicket);
        array_unshift ($keys, 0);

        $values = array_values ($this->typeTicket);
        array_unshift ($values, '--Selecione--');

        return array_combine ($keys, $values);

    }

}
