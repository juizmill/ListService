<?php

namespace ApplicationTest\Model;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Model\Ticket;

/**
 * Class TicketModelTest
 *
 * @package ApplicationTest\Model
 */
class TicketModelTest extends TestCase
{
    use ApplicationMocks;

    public function testIfClasseExcists()
    {
        $class = new Ticket($this->getMockEntityManager(), '\\Application\\Entity\\Ticket');
        $this->assertTrue(class_exists('\\Application\\Model\\Ticket'));
        $this->assertInstanceOf('\\Application\\Model\\AbstractModel', $class);
    }
}
