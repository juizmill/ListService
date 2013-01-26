<?php

namespace LSUser\Form;

use Zend\Form\Form;

/**
 * From User
 *
 * Camada de controle do formulário User
 *
 * @package LSUser\Form
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class User extends Form
{

    public function __construct()
    {
        parent::__construct('user', array());

        $this->setInputFilter(new UserFilter());
        $this->setAttribute('method', 'post');

        //Input Nome
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Nome'
            ),
            'attributes' => array(
                'id' => 'name',
            )
        ));

        //Input Login
        $this->add(array(
            'name' => 'login',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Login'
            ),
            'attributes' => array(
                'id' => 'login',
            )
        ));

        //Input Senha
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Senha'
            ),
            'attributes' => array(
                'id' => 'password',
            )
        ));

        //Input Confirmar Senha
        $this->add(array(
            'name' => 'confirmation',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirmar Senha'
            ),
            'attributes' => array(
                'id' => 'confirmation',
            )
        ));

        //Input Senha
        $this->add(array(
            'name' => 'image',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Imagem'
            ),
            'attributes' => array(
                'id' => 'image',
            )
        ));

        //Input ID
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        
        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);


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
