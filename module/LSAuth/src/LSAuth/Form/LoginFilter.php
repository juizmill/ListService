<?php

namespace LSAuth\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        //Validando campo login
        $this->add(array(
                'name' => 'login',
                'required' => true,
                'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                ),
                'validators' => array(
                        array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                        'messages' => array('isEmpty' => 'O Login não pode esta em branco!')
                                )
                        )
                )
        ));

        //Validando campo login
        $this->add(array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                ),
                'validators' => array(
                        array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                        'messages' => array('isEmpty' => 'A senha não pode esta em branco!')
                                )
                        )
                )
        ));

    }
}
