<?php

namespace ApplicationTest\Controller\Factories;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Controller\Factories\Category as FactoryCategory;

/**
 * Class Category
 *
 * @package ApplicationTest\Controller\Factories
 */
class CategoryTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Controller\Factories\Category
     */
    private $class;

    public $isORM = true;

    public function setUp()
    {
        parent::setup();
        $this->class = new FactoryCategory();
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Controller\\Factories\\Category'));
        $this->assertInstanceOf('\\Zend\\ServiceManager\\FactoryInterface', $this->class);
    }

    public function testReturnControllerCategory()
    {
        $return = $this->class->createService($this->serviceManager);

        $this->assertInstanceOf('\\Application\\Controller\\CategoryController', $return);
    }
}
