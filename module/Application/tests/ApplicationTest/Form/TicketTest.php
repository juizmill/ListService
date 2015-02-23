<?php

namespace ApplicationTest\Form;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Form\Ticket;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class TicketTest
 *
 * @package ApplicationTest\Form
 */
class TicketTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Form\Ticket
     */
    private $class;

    public function setUp()
    {
        parent::setup();
        $this->class = new Ticket(
            new AnnotationBuilder(),
            $this->getMockEntity(),
            $this->getMockModel()
        );
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Form\\Ticket'));
        $this->assertInstanceOf('\\Application\\Form\\AbstractFormHandle', $this->class);
    }
}
