<?php

namespace ApplicationTest\Entity;

use ApplicationTest\Framework\TestCase;
use Application\Entity\User;
use Zend\Crypt\Password\Bcrypt;

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
        $this->assertInstanceOf('Application\\Entity\\AbstractEntity', new User());
        $this->assertInstanceOf('ZfcUser\\Entity\\UserInterface', new User());
    }

    public function dataProviderAttributes()
    {
        return array(
            array('user_name', 'username_test'),
            array('email', 'email_test'),
            array('display_name', 'display_name_test'),
            array('password', 'password_test'),
            array('state', true),
            array('created_at', new \DateTime('2015-01-01 00:00:00')),
            array('updated_at', new \DateTime('2015-01-01 00:00:00')),
            array('salt', 'salt_test'),
            array('active_key', 'active_key_test'),
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

        if ($attribute != 'password') {
            $this->assertEquals($value, $class->$get());
        }
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

    public function testCheckMethodsExistsENCRIPTPASSWORD()
    {
        $this->assertTrue(method_exists('Application\\Entity\\User', 'encryptPassword'));

    }

    public function testCheckreturnMethodPassword()
    {
        $class = new User();
        $class->setPassword('password_test');

        $bcrypt = new Bcrypt();
        $bcrypt->setSalt($class->getSalt());

        $this->assertEquals($class->getPassword(), $bcrypt->create('password_test'));
    }

    public function testCheckExistMethodToArray()
    {
        $this->assertTrue(method_exists('Application\\Entity\\User', 'toArray'));
    }

    public function testCheckMethodConstructSetFullMethods()
    {
        $array = array(
            'id' => 1,
            'user_name' => 'username_test',
            'email' => 'email_test',
            'display_name' => 'display_name_test',
            'description' => 'description_test',
            'password' => 'password_test',
            'state' => true,
            'created_at' => new \DateTime('2015-01-01 00:00:00'),
            'updated_at' => new \DateTime('2015-01-01 00:00:00'),
            'active' => true,
        );

        $class = new User($array);

        $result = $class->toArray();
        $array['salt'] = $class->getSalt();
        $array['password'] = $class->getPassword();
        $array['active_key'] = $class->getActiveKey();

        $this->assertEquals($result, $array);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setActive accept only boolean
     */
    public function testReturnsExceptionIfNotABooleanParameter()
    {
        $class = new User();
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage setState accept only boolean
     */
    public function testReturnsExceptionIfNotABooleanParameterInSetState()
    {
        $class = new User();
        for ($i=0; $i <= 2; $i++) {
            switch ($i) {
                case 0:
                    $class->setState('hello');
                    break;
                case 1:
                    $class->setState(-1);
                    break;
                case 2:
                    $class->setState(0);
                    break;
            }
        }
    }
}
