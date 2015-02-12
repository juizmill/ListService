<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Category;

/**
 * Class CategoryTest
 *
 * @package ApplicationTest\Entity
 */
class CategoryTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Category'));
        $this->assertInstanceOf('Application\Entity\AbstractEntity', new Category());
    }
}
