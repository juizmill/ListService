<?php

namespace ApplicationTest\Framework;

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit_Framework_TestCase;

use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

/**
 * Class TestCase
 * @package ApplicationTest\Framework
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    protected $modules;

    protected $pathDir;

    public function setup()
    {
        parent::setUp();

        $this->pathDir = __DIR__.'/../..';

        if (file_exists($this->pathDir.'/TestConfig.php')) {
            $config = include $this->pathDir.'/TestConfig.php';

            $this->serviceManager = new ServiceManager(new ServiceManagerConfig(
                isset($config['service_manager']) ? $config['service_manager'] : array()
            ));

            $this->serviceManager->setService('ApplicationConfig', $config);
            $this->serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

            $moduleManager = $this->serviceManager->get('ModuleManager');
            $moduleManager->loadModules();
            $this->modules = $moduleManager->getModules();

            $this->serviceManager->setAllowOverride(true);
            self::initDoctrine($this->serviceManager);

            foreach ($this->filterModules() as $m) {
                $this->createDatabase($m);
            }

        } else {
            throw new RuntimeException('Arquivo '.$this->pathDir.'/TestConfig.php'.' não foi encontrado!');
        }
    }

    /**
     * @param $serviceManager \Zend\ServiceManager\ServiceManager
     */
    public static function initDoctrine($serviceManager)
    {
        $config = $serviceManager->get('Config');

        $config['doctrine']['connection']['orm_default'] =
            array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'memory' => true
                )
            );

        $serviceManager->setService('Config', $config);
        $serviceManager->get('doctrine.entity_resolver.orm_default');
    }


    /**
     * @return array
     * @throws \RuntimeException
     */
    protected function filterModules()
    {
        if (! file_exists($this->pathDir.'/TestConfig.php')) {
            throw new RuntimeException('Arquivo '.$this->pathDir.'/TestConfig.php'. ' não encontrado!');
        }

        $config = include $this->pathDir.'/TestConfig.php';

        $array = array();
        foreach ($this->modules as $m) {
            if (! in_array($m, array_merge($config['not_load_entity'], array('DoctrineModule','DoctrineORMModule', 'ZendDeveloperTools')))) {
                $array[] = $m;
            }
        }

        return $array;
    }

    /**
     * createDatabase
     * @param $module
     * @throws \InvalidArgumentException
     */
    public function createDatabase($module)
    {

        $this->tearDown();
        if (file_exists($this->pathDir.'/../config/module.config.php')) {
            $config = require $this->pathDir.'/../config/module.config.php';

            if (isset($config['doctrine'])) {
                $dh = $config['doctrine']['driver'][$module.'_driver']['paths'][0];

                if (is_dir($dh)) {
                    $dir = opendir($dh);

                    $tool = new SchemaTool($this->getEm());

                    $class = array();
                    while (false !== ($filename = readdir($dir))) {
                        if (substr($filename, -4) == ".php") {
                            $class[] = $this->getEm()->getClassMetadata($module.'\\Entity\\'.str_replace('.php', '', $filename));
                        }
                    }
                    $tool->createSchema($class);
                }
            }
        } else {
            throw new \InvalidArgumentException('Nenhum modulo adicionado');
        }
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();

        $module = $this->filterModules();

        foreach ($module as $m) {
            if (file_exists($this->pathDir.'/../config/module.config.php')) {
                $config = require $this->pathDir.'/../config/module.config.php';

                if (isset($config['doctrine'])) {
                    $dh = $config['doctrine']['driver'][$m.'_driver']['paths'][0];
                    if (is_dir($dh)) {
                        $dir = opendir($dh);
                        while (false !== ($filename = readdir($dir))) {
                            if (substr($filename, -4) == ".php") {
                                $tool = new SchemaTool($this->getEm());
                                $class = array(
                                    $this->getEm()->getClassMetadata($m.'\\Entity\\'.str_replace('.php', '', $filename))
                                );
                                $tool->dropSchema($class);
                            }
                        }

                    }
                }
            }
        }
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em = $this->serviceManager->get('Doctrine\ORM\EntityManager');
    }
}
