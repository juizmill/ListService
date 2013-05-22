<?php

namespace LSAuth\Form;

use Zend\Form\Form;

class LoginForm extends Form {

	public function __construct($name = null) {
		parent::__construct();

		$this->setAttribute('method', 'post')->setAttribute('class', 'form-signin');
		$this->setInputFilter(new LoginFilter() );

		//Input
		$this->add(array(
				'name' => 'login',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
						'label' => 'Login'
				),
				'attributes' => array(
						'class' => 'input-block-level',
						'placeholder' => 'Entre com o Login.',
				)
		));

		//Input
		$this->add(array(
				'name' => 'password',
				'type' => 'Zend\Form\Element\Password',
				'options' => array(
						'label' => 'Senha'
				),
				'attributes' => array(
						'class' => 'input-block-level',
						'placeholder' => 'Entre com a Senha',
				)
		));

		//Submit
		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Logar',
						'class' => 'btn btn-large btn-primary'
				),
		));

	}
}

