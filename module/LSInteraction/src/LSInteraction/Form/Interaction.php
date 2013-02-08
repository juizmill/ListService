<?php

namespace LSInteraction\Form;

use Zend\Form\Form;

/**
 * From Interaction
 *
 * Camada de controle do formulário Interaction
 *
 * @package LSInteraction\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Interaction extends Form
{

    public function __construct()
    {
        parent::__construct('interaction', array());

        $this->setInputFilter(new InteractionFilter());
        $this->setAttribute('method', 'post');

        //Input Descrição
        $this->add(array(
            'name' => 'desctiption',
            'type' => 'Zend\Form\Element\TextArea',
            'options' => array(
                'label' => 'description'
            ),
            'attributes' => array(
                'id' => 'description',
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
