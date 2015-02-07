<?php

namespace ApplicationTest\Entity;

use Application\Entity\User;
use ApplicationTest\Framework\TestCase;
use Application\Entity\Ticket;

/**
 * Class TicketTest
 * @package ApplicationTest\Entity
 */
class TicketTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Ticket'));
        $this->assertInstanceOf('Application\Entity\AbstractEntity', new Ticket());
    }

    public function dataProviderAttributes()
    {
        return array(
            array('title', 'title'),
            array('dateBegin', new \DateTime('2015-01-01 00:00:00')),
            array('dateEnd', new \DateTime('2015-01-01 00:00:00')),
            array('dateEstimated', new \DateTime('2015-01-01 00:00:00')),
            array('sought', true),
            array('active', true),
            array('categoryTicket', 'category_ticket_test'),
            array('priority', 'priority_test'),
            array('user', new User()),
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

        $class = new Ticket();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Ticket();
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
            'id' => 1,
            'date_posted' => new \DateTime('2015-01-01 00:00:00'),
            'description' => 'description_test',
            'ticket' => 'ticket_test',
            'user' => new User(),
            'active' => true
        );

        $class = new Ticket($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setId accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        $class = new Ticket();
        for ($i=0; $i <= 2; $i++) {
            switch ($i) {
                case 0:
                    $class->setId('hello');
                    break;
                case 1:
                    $class->setId(-1);
                    break;
                case 2:
                    $class->setId(0);
                    break;
            }
        }
    }
}
