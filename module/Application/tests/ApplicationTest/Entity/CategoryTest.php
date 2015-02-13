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
    /**
     * @var $category \Application\Entity\Category
     */
    private $category;

    public function setUp()
    {
        parent::setup();
        $this->category = new Category();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Category'));
        $this->assertInstanceOf('Application\Entity\AbstractEntity', $this->category);
    }

    public function testDescriptionForTraitInCategory()
    {
        $description = 'Vestibulum id ligula porta felis euismod semper. Curabitur blandit tempus porttitor.';
        $this->category->setDescription($description);

        $this->assertEquals($description, $this->category->getDescription());
    }
}
