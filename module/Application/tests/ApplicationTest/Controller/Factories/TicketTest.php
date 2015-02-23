<?php

namespace ApplicationTest\Controller\Factories;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Controller\Factories\Ticket as FactoryTicket;

/**
 * Class TicketTest
 *
 * @package ApplicationTest\Controller\Factories
 */
class TicketTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Controller\Factories\Ticket
     */
    private $class;

    public $isORM = true;

    public function setUp()
    {
        parent::setup();
        $this->class = new FactoryTicket();
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Controller\\Factories\\Ticket'));
        $this->assertInstanceOf('\\Zend\\ServiceManager\\FactoryInterface', $this->class);
    }

    public function testReturnControllerTicket()
    {
        $return = $this->class->createService($this->serviceManager);

        $this->assertInstanceOf('\\Application\\Controller\\TicketController', $return);
    }
}
