<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;

/**
 * Class AbststractEntityTest
 *
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
            array('identity', 1),
            array('isActive', true),
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
        if ($attribute == 'isActive') {
            $get = str_replace(' ', '', str_replace('_', ' ', $attribute));
            $set = 'setActive';
        } else {
            $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
            $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        }

        $class = $this->getMockAbstractEntity();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        if ($attribute == 'isActive') {
            $set = 'setActive';
        } else {
            $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        }

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
            'identity' => 1,
            'isActive' => true
        );

        $class = $this->getMockAbstractEntity($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setIdentity accept only positive integers greater than zero and
     */
    public function testReturnsExceptionIfNotAnIntegerParameter()
    {
        $class = $this->getMockAbstractEntity();
        for ($i=0; $i <= 2; $i++) {
            switch ($i) {
                case 0:
                    $class->setIdentity('hello');
                    break;
                case 1:
                    $class->setIdentity(-1);
                    break;
                case 2:
                    $class->setIdentity(0);
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
                    $class->isActive(-1);
                    break;
                case 2:
                    $class->isActive(0);
                    break;
            }
        }
    }

    /**
     * @param  array                                    $options
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockAbstractEntity(Array $options = [])
    {
        return $this->getMockForAbstractClass('Application\\Entity\\AbstractEntity', [
                '__construct' => $options
            ]);
    }
}
