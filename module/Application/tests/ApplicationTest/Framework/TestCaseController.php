<?php

namespace ApplicationTest\Framework;

use Doctrine\ORM\Tools\SchemaTool;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use RuntimeException;

/**
 * Class TestCaseController
 *
 * @package ApplicationTest\Framework
 * @SuppressWarnings(PHPMD)
 */
class TestCaseController extends AbstractHttpControllerTestCase
{
    protected $em;
    protected $pathDir;
    public $isORM = false;

    public function setUp()
    {
        parent::setUp();

        $this->pathDir = __DIR__.'/../..';

        $config = $this->pathDir.'/TestConfig.php';

        if (! file_exists($config)) {
            throw new RuntimeException('Arquivo '.$this->pathDir.'/TestConfig.php'.' não foi encontrado!');
        }

        $this->setApplicationConfig(include $config);

        $this->getApplicationServiceLocator()->setAllowOverride(true);

        if ($this->isORM) {
            self::initDoctrine($this->getApplicationServiceLocator());

            foreach ($this->filterModules() as $m) {
                $this->createDatabase($m);
            }
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
        /**
         * @var $moduleManager \Zend\ModuleManager\ModuleManager
         */
        $moduleManager = $this->getApplicationServiceLocator()->get('ModuleManager');

        foreach ($moduleManager->getModules() as $m) {
            if (! in_array($m, array_merge($config['not_load_entity'], array(
                'DoctrineModule',
                'DoctrineORMModule',
                'ZendDeveloperTools'
            )))) {
                $array[] = $m;
            }
        }

        return $array;
    }

    /**
     * createDatabase
     * @param $module
     * @throws \RuntimeException
     */
    public function createDatabase($module)
    {

        $this->tearDown();

        if ($this->isORM) {
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
                                $fileFull = $module.'\\Entity\\'.str_replace('.php', '', $filename);
                                $class[] = $this->getEm()->getClassMetadata($fileFull);
                            }
                        }
                        $tool->createSchema($class);
                    }
                }
            } else {
                throw new RuntimeException('Nenhuma Entity encontrada');
            }
        }
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();

        if ($this->isORM) {
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
                                    $fileFull = $m.'\\Entity\\'.str_replace('.php', '', $filename);
                                    $class = array(
                                        $this->getEm()->getClassMetadata($fileFull)
                                    );
                                    $tool->dropSchema($class);
                                }
                            }

                        }
                    }
                } else {
                    throw new RuntimeException('Nenhuma Entity encontrada');
                }
            }
        }
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em =  $this->getApplicationServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}
