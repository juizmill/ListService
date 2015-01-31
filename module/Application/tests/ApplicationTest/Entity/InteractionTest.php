<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Interaction;

/**
 * Class InteractionTest
 * @package ApplicationTest\Entity
 */
class InteractionTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Interaction'));
    }

    public function dataProviderAttributes()
    {
        return array(
            array('id', 1),
            array('date_posted', new \DateTime('2015-01-01 00:00:00')),
            array('description', 'description_test'),
            array('ticket', 'ticket_test'),
            array('user', 'user_test'),
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

    public function testCheckExistMethodToArray()
    {
        $this->assertTrue(method_exists('Application\\Entity\\Interaction', 'toArray'));
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'date_posted' => new \DateTime('2015-01-01 00:00:00'),
            'description' => 'description_test',
            'ticket' => 'ticket_test',
            'user' => 'user_test'
        );

        $class = new Interaction($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setId accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        $class = new Interaction();
        $class->setId('hello');

        $class2 = new Interaction();
        $class2->setId(-1);

        $class3 = new Interaction();
        $class3->setId(0);
    }
}
