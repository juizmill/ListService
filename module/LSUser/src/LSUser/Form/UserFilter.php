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

    protected $typeUser;

    public function __construct( array $typeUser = null )
    {
        $this->typeUser = array_keys($typeUser);

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
                $this->notEmpty('Nome'),
                $this->stringLength(4, 80, 'Nome'),
            ),
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
                $this->notEmpty('Login'),
                $this->stringLength(4, 20, 'Login'),
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
                $this->notEmpty('Senha'),
                $this->stringLength(4, 15, 'Senha')
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
                $this->notEmpty('Confirmar Senha'),
                $this->stringLength(4, 15, 'Confirmar Senha'),
                $this->identical('Senha', 'password'),
            )
        ));

        //Validando campo select
        $this->add(array(
            'name' => 'TypeUse',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => $this->typeUser,
                        'messages' => array(
                            'notInArray' => 'Selecione um evento!'
                        ),
                    ),
                ),
            ),
        ));

    }

    /**
     * stringLength
     * 
     * Valida campo conforme especificado
     * 
     * @param Integer $min
     * @param Integer $max
     * @param String $inputName
     * @return \Zend\Validator\StringLength
     */
    protected function stringLength( $min, $max, $inputName )
    {

        $stringLength = new \Zend\Validator\StringLength();
        $stringLength->setOptions(array('min' => $min, 'max' => $max))
                ->setMessage("{$inputName} não pode ter menos que {$min} caracter.", \Zend\Validator\StringLength::TOO_SHORT)
                ->setMessage("{$inputName} não pode ter mais que {$max} caracter.", \Zend\Validator\StringLength::TOO_LONG);

        return $stringLength;

    }

    /**
     * notEmpty
     * 
     * Valida se o campo está em branco
     * 
     * @param String $inputName
     * @return \Zend\Validator\NotEmpty
     */
    protected function notEmpty( $inputName )
    {
        $notEmpty = new \Zend\Validator\NotEmpty();
        $notEmpty->setMessage("{$inputName} não pode estar em branco", \Zend\Validator\NotEmpty::IS_EMPTY);

        return $notEmpty;

    }

    /**
     * identical
     * 
     * Valida se o valor de dois campos são iguais
     * 
     * @param String $inputName
     * @param String $compare
     * @return \Zend\Validator\Identical
     */
    protected function identical( $inputName, $compare )
    {
        $identical = new \Zend\Validator\Identical();
        $identical->setOptions(array('token' => $compare))
                ->setMessage("As {$inputName} não conferem.", \Zend\Validator\Identical::NOT_SAME)
                ->setMessage("As {$inputName} não combinam.", \Zend\Validator\Identical::MISSING_TOKEN);

        return $identical;

    }

}