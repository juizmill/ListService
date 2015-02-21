<?php

namespace ApplicationTest\Form;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Form\Priority;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class PriorityTest
 *
 * @package ApplicationTest\Form
 */
class PriorityTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Form\Priority
     */
    private $class;

    public function setUp()
    {
        parent::setup();
        $this->class = new Priority(
            new AnnotationBuilder(),
            $this->getMockEntity(),
            $this->getMockModel()
        );
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Form\\Priority'));
        $this->assertInstanceOf('\\Application\\Form\\AbstractFormHandle', $this->class);
    }
}
