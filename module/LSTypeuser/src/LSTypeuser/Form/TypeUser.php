<?php

namespace LSTypeuser\Form;

use Zend\Form\Form;

/**
 * From TypeUser
 *
 * Camada de controle do formulário TypeUser
 *
 * @package LSTypeuser\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TypeUser extends Form
{

  public function __construct()
  {
    parent::__construct('type_user', array());

    $this->setInputFilter(new TypeUserFilter());
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
            'placeholder' => 'Entre com uma descrição.',
            'maxlength' => 30,
            'class' => 'input-xlarge',
        )
    ));

    //Input Submit
    $this->add(array(
        'name' => 'submit',
        'type' => 'Zend\Form\Element\Submit',
        'attributes' => array(
            'value' => 'Salvar',
            'class' => 'btn btn-success btn-large',
        )
    ));

    //Input ID
    $this->add(array(
        'name' => 'id',
        'type' => 'Zend\Form\Element\Hidden',
    ));
  }

}
