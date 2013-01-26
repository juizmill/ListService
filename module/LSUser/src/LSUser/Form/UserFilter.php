<?php

namespace LSUser\Form;

use Zend\InputFilter\InputFilter;

/**
 * Validação UserFilter
 *
 * Camada de controle de validação do formulário User
 *
 * @package LSUser\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class UserFilter extends InputFilter
{

    public function __construct()
    {

        /**
         * Validando o campo Nome
         */
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Nome não pode estar em branco')))
            )
        ));
        
        /**
         * Validando o campo login
         */
        $this->add(array(
            'name' => 'login',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Login não pode estar em branco')))
            )
        ));
        
        /**
         * Validando o campo Senha
         */
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Senha não pode estar em branco')))
            )
        ));
        
        /**
         * Validando o campo Confirmação
         */
        $this->add(array(
            'name' => 'confirmation',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array('messages' => array('isEmpty' => 'Campo comfirmação não pode estar em branco')),
                    'name' => 'Identical', 'options' => array('token' => 'password')
                )
            )
        ));
    }

}