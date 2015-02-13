<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Priority;

/**
 * Class PriorityTest
 *
 * @package ApplicationTest\Entity
 */
class PriorityTest extends TestCase
{
    /**
     * @var $priority \Application\Entity\Priority
     */
    private $priority;

    public function setUp()
    {
        parent::setup();
        $this->priority = new Priority();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Priority'));
        $this->assertInstanceOf('Application\Entity\AbstractEntity', $this->priority);
    }

    public function testDescriptionForTraitInPriority()
    {
        $description = 'Vestibulum id ligula porta felis euismod semper. Curabitur blandit tempus porttitor.';
        $this->priority->setDescription($description);

        $this->assertEquals($description, $this->priority->getDescription());
    }
}
