<?php

namespace LSCategoryticket\Form;

use Zend\Form\Form;

/**
 * From CategoryTicket
 *
 * Camada de controle do formulário CategoryTicket
 *
 * @package LSCategoryticket\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class CategoryTicket extends Form
{

  public function __construct()
  {
    parent::__construct('category-ticket', array());

    $this->setInputFilter(new CategoryTicketFilter());
    $this->setAttribute('method', 'post');

    //Input descrição
    $this->add(array(
        'name' => 'description',
        'type' => 'Zend\Form\Element\Text',
        'options' => array(
            'label' => 'Descrição'
        ),
        'attributes' => array(
            'id' => 'description',
        )
    ));

    //Input Submit
    $this->add(array(
        'name' => 'salval',
        'type' => 'Zend\Form\Element\Submit',
        'attributes' => array(
            'value' => 'Salvar',
        )
    ));

    //Input ID
    $this->add(array(
        'name' => 'id',
        'type' => 'Zend\Form\Element\Hidden',
    ));
  }

}
