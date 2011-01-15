<?php

namespace blaze\persistence;

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
    protected $entityManager;

    protected function setUp() {
        $this->config = new \blaze\persistence\cfg\Configuration();
    }

    protected function tearDown() {

    }

    public function testConfigure(){
        $this->config = new cfg\Configuration();
        $this->config->configureFile('D:\\xampp\\htdocs\\BlazeFrameworkServer\\src\\blazeCMS\\source\\persistence.cfg.xml');
        $this->factory = $this->config->buildEntityManagerFactory();
        $this->entityManager = $this->factory->createEntityManager();
    }

}

?>
