<?php

namespace ApplicationTest\Model;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Model\Category;

/**
 * Class CategoryModelTest
 *
 * @package ApplicationTest\Model
 */
class CategoryModelTest extends TestCase
{
    use ApplicationMocks;

    public function testIfClasseExcists()
    {
        $class = new Category($this->getMockEntityManager(), '\\Application\\Entity\\Category');
        $this->assertTrue(class_exists('\\Application\\Model\\Category'));
        $this->assertInstanceOf('\\Application\\Model\\AbstractModel', $class);
    }
}
