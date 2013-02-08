<?php

namespace LSPriority\Form;

use Zend\InputFilter\InputFilter;

/**
 * Validação TypeUserFilter
 *
 * Camada de controle de validação do formulário Priority
 *
 * @package LSPriority\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class PriorityFilter extends InputFilter
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