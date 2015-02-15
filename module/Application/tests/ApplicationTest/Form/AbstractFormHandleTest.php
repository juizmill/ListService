<?php

namespace ApplicationTest\Form;

use ApplicationTest\Framework\TestCase;
use Zend\Form\Annotation\AnnotationBuilder;
use ApplicationTest\Model\ExempleEntity;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class AbstractFormHandle
 *
 * @package ApplicationTest\Form
 */
class AbstractFormHandleTest extends TestCase
{
    public function testCheckIfClassExists()
    {
        $this->assertTrue(class_exists('\\Application\\Form\\AbstractFormHandle'));
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return array(
            ['model', $this->getMockModel()],
            ['form', $this->getMockForm()],
            ['entity', $this->getMockEntity()],
        );
    }

    public function testCheckAttributesExpected()
    {
        $class = '\\Application\\Form\\AbstractFormHandle';
        $this->assertClassHasAttribute('model', $class);
        $this->assertClassHasAttribute('entity', $class);
        $this->assertClassHasAttribute('form', $class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCheckIfClassGetAndSets($attribute, $value)
    {
        $get = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $set = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        $class = $this->getMockForAbstractClass('\\Application\\Form\\AbstractFormHandle', array(
            new AnnotationBuilder(),
            $this->getMockEntity(),
            $this->getMockModel()
        ));
        $class->$set($value);
        $this->assertEquals($value, $class->$get());
    }

    public function testCheckMethodHandle()
    {
        $this->assertTrue(method_exists('\\Application\\Form\\AbstractFormHandle', 'handle'));

        /**
         * @var $class \Application\Form\AbstractFormHandle
         */
        $class = $this->getMockForAbstractClass('\\Application\\Form\\AbstractFormHandle', array(
            new AnnotationBuilder(),
            new ExempleEntity(),
            $this->getMockModel()
        ));
        $this->assertInstanceOf('\Zend\Form\Form', $class->handle(new Request()));

        $request = new Request();
        $request->setMethod('POST')
            ->setPost(new Parameters(
                ['isActive' => true]
            ));

        $this->assertInstanceOf('ApplicationTest\Model\ExempleEntity', $class->handle($request));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockModel()
    {
        return $this->getMockForAbstractClass('\\Application\\Model\\AbstractModel', array(
            $this->getEmMock(),
            '\\ApplicationTest\\Model\\ExempleEntity'
        ));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntity()
    {
        return $this->getMockForAbstractClass('\\Application\\Entity\\AbstractEntity');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockForm()
    {
        return $this->getMock('\\Zend\\Form\\Form', array(), array(), '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEmMock()
    {
        $emMock = $this->getMock('\\Doctrine\\ORM\\EntityManager',
            ['persist', 'flush', 'getReference', 'remove'],
            [],
            '',
            false
        );

        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        return $emMock;
    }
}
