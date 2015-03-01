<?php

namespace Application\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Button;
use Zend\Form\Element\Email;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

/**
 * Class RecoveryPassword
 *
 * @package Application\src\Application\Form
 */
class RecoveryPassword extends Form
{
    public function __construct()
    {
        parent::__construct('recovery-password');
        $this->setAttributes([
            'method' => 'POST',
            'role' => 'form',
            'novalidate' => 'novalidate'
        ]);
        $this->setInputFilter($this->inputFilter());

        $email = new Email('email');
        $email->setLabel('E-mail');
        $email->setAttributes([
            'class' => 'form-control',
        ]);
        $this->add($email);

        $button = new Button('recovery');
        $button->setLabel('Recovery')
            ->setAttributes(array(
                'class' => 'btn bg-olive btn-block',
                'type' => 'submit',
            ));
        $this->add($button);
    }

    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function inputFilter()
    {
        $inputFilter = new InputFilter();

        $email = new Input('email');
        $email->getValidatorChain()->attach(new EmailAddress());
        $email->getFilterChain()->attach(new StringTrim())->attach(new StripTags());

        return $inputFilter->add($email);
    }
}
