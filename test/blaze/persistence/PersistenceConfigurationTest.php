<?php

namespace blaze\persistence;

require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Reflectable.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Object.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');

/**
 * Test class for PersistenceConfigurationTest.
 * Generated by PHPUnit on 2010-08-31 at 23:54:33.
 */
class PersistenceConfigurationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var blaze\persistence\cfg\Configuration
     */
    protected $config;
    /**
     *
     * @var blaze\persistence\EntityManagerFactory
     */
    protected $factory;
    /**
     *
     * @var blaze\persistence\EntityManager
     */
    protected $EntityManager;

    protected function setUp() {
        $this->config = new \blaze\persistence\cfg\Configuration();
    }

    protected function tearDown() {

    }

    public function testConfigure(){
        $this->config = new cfg\Configuration();
        $this->config->configureFile('D:\\xampp\\htdocs\\BlazeFrameworkServer\\src\\blazeCMS\\source\\persistence.cfg.xml');
        $this->factory = $this->config->buildEntityManagerFactory();
        $this->EntityManager = $this->factory->openEntityManager();
    }

}

?>
