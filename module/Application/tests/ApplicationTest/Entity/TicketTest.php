<?php

namespace ApplicationTest\Entity;

use Application\Entity\Priority;
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
    }

    public function dataProviderAttributes()
    {
        return array(
            array('id', 1),
            array('title', 'test_title'),
            array('date_start', new \DateTime('2015-01-01 00:00:00')),
            array('date_end', new \DateTime('2015-01-01 00:00:00')),
            array('date_estimated', new \DateTime('2015-01-01 00:00:00')),
            array('sought', 'test_sought'),
            array('active', true),
            array('priority', new Priority()),
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
            'title' => 'test_title',
            'date_start' => new \DateTime('2015-01-01 00:00:00'),
            'date_end' => new \DateTime('2015-01-01 00:00:00'),
            'date_estimated' => new \DateTime('2015-01-01 00:00:00'),
            'sought' => 'test_sought',
            'active' => true,
            'priority'=> new Priority(),
            'user' => new User(),
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
