<?php

namespace ApplicationTest\Framework;

use ApplicationTest\Model\ExempleEntity;
use Zend\Form\Annotation\AnnotationBuilder;

/**
 * Trait ApplicationMocks
 *
 * @package ApplicationTest\Framework
 */
trait ApplicationMocks
{
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getMockEntityManager()
    {
        return $this->getMockBuilder('\\Doctrine\\ORM\\EntityManager')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return mixed
     */
    public function getMockEntity()
    {
        return $this->getMockForAbstractClass('\\Application\\Entity\\AbstractEntity');
    }

    /**
     * @return mixed
     */
    public function getMockModel()
    {
        return $this->getMockForAbstractClass('\\Application\\Model\\AbstractModel', array(
            $this->getEmMock(),
            '\\ApplicationTest\\Model\\ExempleEntity'
        ));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getEmMock()
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

    private function getMockFormHandle()
    {
        $class = $this->getMockForAbstractClass('\\Application\\Form\\AbstractFormHandle', array(
            new AnnotationBuilder(),
            new ExempleEntity(),
            $this->getMockModel()
        ));

        return $class;
    }
}
