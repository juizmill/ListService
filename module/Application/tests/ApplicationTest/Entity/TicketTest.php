<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Ticket;

/**
 * Class TicketTest
 *
 * @package ApplicationTest\Entity
 */
class TicketTest extends TestCase
{
    /**
     * @var $ticket \Application\Entity\Ticket
     */
    private $ticket;

    public function setUp()
    {
        parent::setup();
        $this->ticket = new Ticket();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Ticket'));
    }

    public function dataProviderAttributes()
    {
        return array(
            array('identity', 1),
            array('title', 'test_title'),
            array('dateStart', new \DateTime('2015-01-01 00:00:00')),
            array('dateEnd', new \DateTime('2015-01-01 00:00:00')),
            array('dateEstimated', new \DateTime('2015-01-01 00:00:00')),
            array('sought', 'test_sought'),
            array('priority', $this->getMockPriority()),
            array('user', $this->getMockUser()),
        );
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckAttritutesExpected($attribute)
    {
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\Ticket');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = $this->ticket;
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = $this->ticket;
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\Ticket', $result);
    }

    public function testCheckExistMethodToArray()
    {
        $this->assertTrue(method_exists('Application\\Entity\\Ticket', 'toArray'));
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'identity' => 1,
            'title' => 'test_title',
            'dateStart' => new \DateTime('2015-01-01 00:00:00'),
            'dateEnd' => new \DateTime('2015-01-01 00:00:00'),
            'dateEstimated' => new \DateTime('2015-01-01 00:00:00'),
            'sought' => 'test_sought',
            'isActive' => true,
            'priority'=> $this->getMockPriority(),
            'user' => $this->getMockUser(),
        );

        $class = new Ticket($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPriority()
    {
        return $this->getMockBuilder('\\Application\\Entity\\Priority')->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockUser()
    {
        return $this->getMockBuilder('\\Application\\Entity\\User')->getMock();
    }
}
