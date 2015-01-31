<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\Priority;

/**
 * Class AbststractEntityTest
 * @package ApplicationTest\Entity
 */
class AbststractEntityTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\AbstractEntity'));
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
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\AbstractEntity');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = $this->getMockAbstractEntity();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = $this->getMockAbstractEntity();
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\AbstractEntity', $result);
    }

    public function testCheckExistMethodToArray()
    {
        $this->assertTrue(method_exists('Application\\Entity\\AbstractEntity', 'toArray'));
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'description' => 'description_test',
            'active' => true
        );

        $class = $this->getMockAbstractEntity($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setId accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        $class = $this->getMockAbstractEntity();
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
        $class = $this->getMockAbstractEntity();
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

    private function getMockAbstractEntity(Array $options = [])
    {
        return $this->getMockForAbstractClass('Application\\Entity\\AbstractEntity', [
                '__construct' => $options
            ]);
    }
}
