<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\User;

/**
 * Class UserTest
 * @package ApplicationTest\Entity
 */
class UserTest extends TestCase
{
    protected $traceError = true;

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\User'));
        $this->assertInstanceOf('ZfcUserDoctrineORM\\Entity\\User', new User());
    }

    public function dataProviderAttributes()
    {
        return array(
            array('id', 1),
            array('username', 'username_test'),
            array('email', 'email_test'),
            array('display_name', 'display_name_test'),
            array('password', 'password_test'),
            array('state', 'state_test'),
            array('created_at', new \DateTime('2015-01-01 00:00:00')),
            array('updated_at', new \DateTime('2015-01-01 00:00:00')),
            array('active', true),
        );
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckAttritutesExpected($attribute)
    {
        $this->assertClassHasAttribute($attribute, 'Application\\Entity\\User');
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckGetAndSetExpected($attribute, $value)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new User();
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = new User();
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\User', $result);
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'username' => 'username_test',
            'email' => 'email_test',
            'display_name' => 'display_name_test',
            'password' => 'password_test',
            'state' => 'state_test',
            'created_at' => new \DateTime('2015-01-01 00:00:00'),
            'updated_at' => new \DateTime('2015-01-01 00:00:00'),
            'active' => true,
        );

        $class = new User($array);

        $result = $class->toArray();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setActive accept only boolean
     */
    public function testReturnsExceptionIfNotABooleanParameter()
    {
        $class = new User();
        $class->setActive('hello');

        $class2 = new User();
        $class2->setActive(1);

        $class3 = new User();
        $class3->setActive(0);
    }

    public function testCheckExistMethodToArray()
    {
        $class = new User();
        $class->setId(1)
            ->setUsername('username_test')
            ->setEmail('email_test')
            ->setDisplayName('display_name_test')
            ->setPassword('password_test')
            ->setState('state_test')
            ->setCreatedAt(new \DateTime('2015-01-01 00:00:00'))
            ->setUpdatedAt(new \DateTime('2015-01-01 00:00:00'))
            ->setActive(true);

        $result = $class->toArray();

        $array = array(
            'id' => 1,
            'username' => 'username_test',
            'email' => 'email_test',
            'display_name' => 'display_name_test',
            'password' => 'password_test',
            'state' => 'state_test',
            'created_at' => new \DateTime('2015-01-01 00:00:00'),
            'updated_at' => new \DateTime('2015-01-01 00:00:00'),
            'active' => true,
        );

        $this->assertEquals($result, $array);
    }
}
