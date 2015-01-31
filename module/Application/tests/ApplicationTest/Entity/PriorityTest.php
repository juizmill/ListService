<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Priority;

/**
 * Class PriorityTest
 * @package ApplicationTest\Entity
 */
class PriorityTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Priority'));
        $this->assertInstanceOf('Application\Entity\AbstractEntity', new Priority());
    }
}
