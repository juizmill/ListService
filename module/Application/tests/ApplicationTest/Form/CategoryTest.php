<?php

namespace ApplicationTest\Form;

use ApplicationTest\Framework\ApplicationMocks;
use ApplicationTest\Framework\TestCase;
use Application\Form\Category;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Class CategoryTest
 *
 * @package ApplicationTest\Form
 */
class CategoryTest extends TestCase
{
    use ApplicationMocks;

    /**
     * @var $class \Application\Form\Category
     */
    private $class;

    public function setUp()
    {
        parent::setup();
        $this->class = new Category(
            new AnnotationBuilder(),
            $this->getMockEntity(),
            $this->getMockModel()
        );
    }

    public function testIfClasseExists()
    {
        $this->assertTrue(class_exists('\\Application\\Form\\Category'));
        $this->assertInstanceOf('\\Application\\Form\\AbstractFormHandle', $this->class);
    }
}
