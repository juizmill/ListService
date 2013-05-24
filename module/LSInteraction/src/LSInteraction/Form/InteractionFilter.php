<?php

namespace LSInteraction\Form;

use Zend\InputFilter\InputFilter;

/**
 * Validação InteractionFilter
 *
 * Camada de controle de validação do formulário Interaction
 *
 * @package LSInteraction\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class InteractionFilter extends InputFilter
{

    public function __construct()
    {

        /**
         * Validando o campo Descrição
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
