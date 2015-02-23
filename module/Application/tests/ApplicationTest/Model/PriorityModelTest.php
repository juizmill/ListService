<?php

namespace ApplicationTest\Model;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Model\Priority;

/**
 * Class PriorityModelTest
 *
 * @package ApplicationTest\Model
 */
class PriorityModelTest extends TestCase
{
    use ApplicationMocks;

    public function testIfClasseExcists()
    {
        $class = new Priority($this->getMockEntityManager(), '\\Application\\Entity\\Priority');
        $this->assertTrue(class_exists('\\Application\\Model\\Priority'));
        $this->assertInstanceOf('\\Application\\Model\\AbstractModel', $class);
    }
}
