<?php

namespace LSCategoryticket\Form;

use Zend\InputFilter\InputFilter;

/**
 * Validação CategoryTicketFilter
 *
 * Camada de controle de validação do formulário CategoryTicketFilter
 *
 * @package LSCategoryticket\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class CategoryTicketFilter extends InputFilter
{

  public function __construct()
  {

    /**
     * Validando o campo descrição
     */
    $this->add(array(
        'name' => 'description',
        'required' => true,
        'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
        ),
        'validators' => array(
            array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Não pode estar em branco')))
        )
    ));
    
  }

}