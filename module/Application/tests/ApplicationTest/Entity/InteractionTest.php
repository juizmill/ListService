<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Interaction;

/**
 * Class InteractionTest
 *
 * @package ApplicationTest\Entity
 */
class InteractionTest extends TestCase
{
    /**
     * @var $interaction \Application\Entity\Interaction
     */
    private $interaction;

    public function setUp()
    {
        parent::setup();
        $this->interaction = new Interaction();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('\\Application\\Entity\\Interaction'));
        $this->assertInstanceOf('\\Application\\Entity\\AbstractEntity', $this->interaction);
    }

    public function dataProviderAttributes()
    {
        return array(
            array('datePosted', new \DateTime('2015-01-01 00:00:00')),
            array('ticket', $this->getMockTicket()),
            array('user',  $this->getMockUser()),
        );
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckAttritutesExpected($attribute)
    {
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\Interaction');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Interaction();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Interaction();
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\Interaction', $result);
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'identity' => 1,
            'datePosted' => new \DateTime('2015-01-01 00:00:00'),
            'description' => 'description_test',
            'ticket' => $this->getMockTicket(),
            'user' => $this->getMockUser(),
            'isActive' => true
        );

        $class = new Interaction($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setIdentity accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        for ($i=0; $i <= 2; $i++) {
            switch ($i) {
                case 0:
                    $this->interaction->setIdentity('hello');
                    break;
                case 1:
                    $this->interaction->setIdentity(-1);
                    break;
                case 2:
                    $this->interaction->setIdentity(0);
                    break;
            }
        }
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockUser()
    {
        return $this->getMockBuilder('\\Application\\Entity\\User')->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockTicket()
    {
        return $this->getMockBuilder('\\Application\\Entity\\Ticket')->getMock();
    }
}
