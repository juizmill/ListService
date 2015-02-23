<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\User;

/**
 * Class UserTest
 *
 * @package ApplicationTest\Entity
 */
class UserTest extends TestCase
{
    /**
     * @var $user \Application\Entity\User
     */
    private $user;

    public function setUp()
    {
        parent::setup();
        $this->user = new User();
    }

    public function testClasseExist()
    {
        $this->assertTrue(class_exists('Application\\Entity\\User'));
        $this->assertInstanceOf('ZfcUser\\Entity\\UserInterface', new User());
    }

    public function dataProviderAttributes()
    {
        return array(
            array('username', 'username_test'),
            array('email', 'email_test'),
            array('displayName', 'display_name_test'),
            array('password', 'password_test'),
            array('state', true),
            array('createdAt', new \DateTime('2015-01-01 00:00:00')),
            array('updatedAt', new \DateTime('2015-01-01 00:00:00')),
            array('activeKey', 'active_key_test'),
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

        $class = $this->user;
        $class->$set($value);

        $this->assertEquals($value, $class->$get());
    }

    /**
     * @dataProvider dataProviderAttributes
     */
    public function testCheckMethodsFluid($attribute, $value)
    {
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));

        $class = $this->user;
        $result = $class->$set($value);

        $this->assertInstanceOf('Application\\Entity\\User', $result);
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'identity' => 1,
            'username' => 'username_test',
            'email' => 'email_test',
            'displayName' => 'display_name_test',
            'password' => 'password_test',
            'state' => 1,
            'createdAt' => new \DateTime('2015-01-01 00:00:00'),
            'updatedAt' => new \DateTime('2015-01-01 00:00:00'),
            'isActive' => true,
        );

        $class = new User($array);

        $result = $class->toArray();
        $array['activeKey'] = $class->getActiveKey();

        $this->assertEquals($result, $array);
    }
}
