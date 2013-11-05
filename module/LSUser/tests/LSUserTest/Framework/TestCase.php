<?php
namespace LSUserTest\Framework;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Zend\ServiceManager\ServiceManager;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
    * @var ServiceManager
    */
    protected static $sm;

    /**
    * @param ServiceManager $sm
    */
    public static function setServiceManager(ServiceManager $sm)
    {
        self::$sm = $sm;
    }

    /**
    * @return ServiceManager
    */
    public function getServiceManager()
    {
     return self::$sm;
    }

    /**
    * Get EntityManager.
    *
    * @return EntityManager
    */
    public function getEntityManager()
    {
        return $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
    }
}