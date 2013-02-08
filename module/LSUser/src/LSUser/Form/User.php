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

    protected $typeUser;
    
    public function __construct (array $typeUser = null)
    {
      
        parent::__construct ('user', array());

        $this->typeUser = $typeUser;
        
        $this->setInputFilter (new UserFilter ($this->typeUser));
        $this->setAttribute ('method', 'post');

        //Input Nome
        $this->add (array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Nome'
            ),
            'attributes' => array(
                'id' => 'name',
                'maxlength' => 80,
            )
        ));

        //Input Login
        $this->add (array(
            'name' => 'login',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Login'
            ),
            'attributes' => array(
                'id' => 'login',
                'maxlength' => 15,
            )
        ));

        //Input Senha
        $this->add (array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Senha'
            ),
            'attributes' => array(
                'id' => 'password',
                'maxlength' => 15,
            )
        ));

        //Input Confirmar Senha
        $this->add (array(
            'name' => 'confirmation',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirmar Senha'
            ),
            'attributes' => array(
                'id' => 'confirmation',
                'maxlength' => 15,
            )
        ));

        //Input Senha
        $this->add (array(
            'name' => 'image',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Imagem'
            ),
            'attributes' => array(
                'id' => 'image',
            )
        ));

        //Select Tipo de usuario
        $this->add (array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'TypeUse',
            'options' => array(
                'label' => 'Evento',
                'value_options' => $this->typeUserSelect (),
            ),
            'attributes' => array(
                'value' => '0',
                'id' => 'typeUser',
            ),
        ));

        //Input ID
        $this->add (array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $csrf = new \Zend\Form\Element\Csrf ("security");
        $csrf->setCsrfValidatorOptions(array('messages'=> array('notSame' => 'Pressione o botão salvar para cadastrar.')));
        $this->add ($csrf);

        //Input Submit
        $this->add (array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
            )
        ));

    }

    /**
     * ticketTypeSelect
     * 
     * Faz o tratamento dos tipos de ticket que vem no formato de array
     * adiciona no primeiro índice do array o "--Selecione--"
     * e retorna o array com todos os tipos de ticket mais o "--Selecione--"
     * 
     * @return array
     */
    protected function typeUserSelect ()
    {
        $keys = array_keys ($this->typeUser);
        array_unshift ($keys, 0);

        $values = array_values ($this->typeUser);
        array_unshift ($values, '--Selecione--');

        return array_combine ($keys, $values);

    }

}
