<?php

namespace ApplicationTest\Controller\Factories;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Controller\Factories\Priority as FactoryPriority;

/**
 * Class PriorityTest
 *
 * @package ApplicationTest\Controller\Factories
 */
class PriorityTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Controller\Factories\Priority
     */
    private $class;

    public $isORM = true;

    public function setUp()
    {
        parent::setup();
        $this->class = new FactoryPriority();
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Controller\\Factories\\Priority'));
        $this->assertInstanceOf('\\Zend\\ServiceManager\\FactoryInterface', $this->class);
    }

    public function testReturnControllerPriority()
    {
        $return = $this->class->createService($this->serviceManager);

        $this->assertInstanceOf('\\Application\\Controller\\PriorityController', $return);
    }
}
