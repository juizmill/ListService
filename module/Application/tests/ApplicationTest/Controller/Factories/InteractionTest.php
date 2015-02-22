<?php

namespace ApplicationTest\Controller\Factories;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Controller\Factories\Interaction as FactoryInteraction;

/**
 * Class InteractionTest
 *
 * @package ApplicationTest\Controller\Factories
 */
class InteractionTest extends TestCase
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
        $this->class = new FactoryInteraction();
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Controller\\Factories\\Interaction'));
        $this->assertInstanceOf('\\Zend\\ServiceManager\\FactoryInterface', $this->class);
    }

    public function testReturnControllerInteraction()
    {
        $return = $this->class->createService($this->serviceManager);

        $this->assertInstanceOf('\\Application\\Controller\\InteractionController', $return);
    }
}
