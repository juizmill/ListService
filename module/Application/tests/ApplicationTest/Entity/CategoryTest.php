<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Category;

/**
 * Class CategoryTest
 * @package ApplicationTest\Entity
 */
class CategoryTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\Category'));
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
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\Category');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Category();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new Category();
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\Category', $result);
    }

    public function testCheckExistMethodToArray()
    {
        $this->assertTrue(method_exists('Application\\Entity\\User', 'toArray'));
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'description' => 'description_test',
            'active' => true
        );

        $class = new Category($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setId accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        $class = new Category();
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setActive accept only boolean
     */
    public function testReturnsExceptionIfNotABooleanParameter()
    {
        $class = new Category();
        for ($i=0; $i <= 2; $i++) {
            switch ($i) {
                case 0:
                    $class->setActive('hello');
                    break;
                case 1:
                    $class->setActive(-1);
                    break;
                case 2:
                    $class->setActive(0);
                    break;
            }
        }
    }
}
