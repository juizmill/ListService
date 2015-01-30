<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Priority;

/**
 * Class PriorityTest
 * @package ApplicationTest\Entity
 */
class PriorityTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Priority'));
    }

    public function dataProviderAttributes()
    {
        return array(
            array('id', 1),
            array('description', 'description_test'),
            array('active', true),
        );
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckAttritutesExpected($attribute)
    {
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\Priority');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Priority();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Priority();
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\Priority', $result);
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'description' => 'description_test',
            'active' => true
        );

        $class = new Priority($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }


    public function testCheckExistMethodToArray()
    {
        $class = new Priority();
        $class->setId(1)
            ->setDescription('description_test')
            ->setActive(true);

        $result = $class->toArray();

        $array = array(
            'id' => 1,
            'description' => 'description_test',
            'active' => true
        );

        $this->assertEquals($result, $array);
    }
}
