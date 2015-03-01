<?php

namespace ApplicationTest\Form;

use ApplicationTest\Framework\TestCase;
use Application\Form\RecoveryPassword;

/**
 * Class RecoveryPasswordTest
 *
 * @package ApplicationTest\Form
 */
class RecoveryPasswordTest extends TestCase
{
    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Form\\RecoveryPassword'));
        $this->assertInstanceOf('Zend\Form\form', new RecoveryPassword());
    }

}
