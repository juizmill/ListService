<?php

namespace ApplicationTest\Model;

use ApplicationTest\Framework\TestCase;
use Application\Model\AbstractModel;
use ApplicationTest\Model\ExempleEntity;

/**
 * Class AbstractModelTest
 *
 * @package ApplicationTest\Model
 */
class AbstractModelTest extends TestCase
{
    /**
     * @var $classExemple \ApplicationTest\Model\ExempleEntity
     */
    private $classExemple;

    public function setUp()
    {
        parent::setup();
        $this->classExemple = new ExempleEntity();
    }

    public function testCheckIfClassExists()
    {
        $this->assertTrue(class_exists('\\Application\\Model\\AbstractModel'));
        $this->assertInstanceOf('\\Application\\Model\\Interfaces\\ModelInterface', $this->getMockAbstractModel());
    }

    public function dataProviderAttributes()
    {
        return array(
            array('entityManager'),
            array('entity'),
        );
    }

    public function testCheckIfRealizedInsert()
    {
        $this->classExemple->setActive(true);
        $model = $this->getMockAbstractModel();
        $save = $model->save($this->classExemple);

        $this->assertEquals($this->classExemple, $save);
    }

    public function testCheckIfRealizedUpdate()
    {
        $this->classExemple->setIdentity(1);
        $this->classExemple->setActive(false);
        $model = $this->getMockAbstractModel();
        $save = $model->save($this->classExemple);

        $this->assertEquals($this->classExemple, $save);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockAbstractModel()
    {
        $mock = $this->getMockForAbstractClass('\\Application\\Model\\AbstractModel', [
            $this->getMockEntityManager(), get_class($this->classExemple)
        ]);

        $mock->expects($this->any())
            ->method('save')
            ->with($this->equalTo($this->classExemple))
            ->will($this->returnValue($this->classExemple));

        $mock->expects($this->any())
            ->method('remove')
            ->with($this->equalTo(1))
            ->will($this->returnValue(null));

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        return $this->getMockBuilder('\\Doctrine\\ORM\\EntityManager')->disableOriginalConstructor()->getMock();
    }
}
