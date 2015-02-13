<?php

namespace ApplicationTest\Helpers;

use ApplicationTest\Framework\TestCase;
use Application\Helpers\ContentHeader;

class ContentHeaderTest extends TestCase
{
    public function testCheckIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Helpers\\ContentHeader'));
        $this->assertInstanceOf('\\Zend\\View\\Helper\\AbstractHelper', new ContentHeader());
    }

    public function testCheckMethodInvoke()
    {
        $this->assertTrue(method_exists('\\Application\\Helpers\\ContentHeader', '__invoke'));

        $class = new ContentHeader();

        $this->assertTrue(is_callable($class));

        $expected = "<h1>header<small>Content</small></h1>";

        $this->assertEquals($expected, $class('header', 'Content'));
    }
}
