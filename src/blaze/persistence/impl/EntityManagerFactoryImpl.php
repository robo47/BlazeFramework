<?php

namespace blaze\persistence\impl;

use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class EntityManagerFactoryImpl extends Object implements \blaze\persistence\EntityManagerFactory {

    private $properties;
    private $ressources;
    private $ds;
    private $dialect;
    private $mapping = array();
    private $freeConnections;
    private $usedConnections;
    private $closed = false;

    public function __construct(\blaze\collections\map\Properties $properties, \blaze\collections\ListI $ressources) {
        $driverName = $properties->getProperty('persistence.connection.datasource.class');

        if ($driverName != null) {
            $dsClass = \blaze\lang\ClassWrapper::forName($driverName);
            $dsHost = $properties->getProperty('persistence.connection.datasource.host');
            $dsPort = $properties->getProperty('persistence.connection.datasource.port');
            $dsDatabase = $properties->getProperty('persistence.connection.datasource.database');
            $dsUsername = $properties->getProperty('persistence.connection.datasource.username');
            $dsPassword = $properties->getProperty('persistence.connection.datasource.password');
            $dsOptions = $properties->getProperty('persistence.connection.datasource.options');
            $this->ds = $dsClass->getMethod('getDataSource')->invokeArgs(null, array($dsHost, $dsPort, $dsDatabase, $dsUsername, $dsPassword, $dsOptions));
        } else {
            $dsn = $properties->getProperty('persistence.connection.datasource.url');
            $dsUsername = $properties->getProperty('persistence.connection.datasource.username');
            $dsPassword = $properties->getProperty('persistence.connection.datasource.password');
            $dsOptions = $properties->getProperty('persistence.connection.datasource.options');
            $this->ds = \blaze\ds\DataSourceManager::getInstance()->getDataSource($dsn, $dsUsername, $dsPassword, $dsOptions);
        }

        $this->dialect = \blaze\lang\ClassWrapper::forName($properties->getProperty('persistence.dialect'))->newInstance();

        foreach ($ressources as $ressource) {
            $this->loadMapping($ressource);
        }

        $this->properties = $properties;
        $this->ressources = $ressources;
        $this->freeConnections = new \blaze\collections\queue\Stack();
        $this->usedConnections = new \blaze\collections\map\HashMap();
    }

    public function close() {
        $this->closed = true;
        $iter = $this->usedConnections->getIterator();

        while ($iter->hasNext()) {
            $entry = $iter->next();
            $EntityManager = $entry->getKey();

            if ($EntityManager != null && !$EntityManager->isClosed()) {
                $con = $entry->getValue();
                $EntityManager->close();
                $this->freeConnections->push($con);
                $iter->remove();
            }
        }
    }

    private function freeClosedEntityManagers() {
        $iter = $this->usedConnections->getIterator();

        while ($iter->hasNext()) {
            $entry = $iter->next();
            $EntityManager = $entry->getKey();

            if ($EntityManager != null && $EntityManager->isClosed()) {
                $con = $entry->getValue();
                $this->freeConnections->push($con);
                $iter->remove();
            }
        }
    }

    private function loadMapping(\blaze\persistence\meta\ClassDescriptor $class) {
        $fullClassName = $class->getPackage().'\\'.$class->getName();
        $this->mapping[$fullClassName] = $class;
    }

    public function isClosed() {
        return $this->closed;
    }

    public function createEntityManager() {
        $con = null;

        if ($this->freeConnections->count() == 0) {
            $this->freeClosedEntityManagers();

            if ($this->freeConnections->count() == 0)
                $con = $this->ds->getConnection();
            else
                $con = $this->freeConnections->pop();
        }else {
            $con = $this->freeConnections->pop();
        }

        $sess = new EntityManagerImpl($con, $this, $this->dialect);
        $this->usedConnections->put($sess, $con);
        return $sess;
    }

    public function getClassDescriptor($className) {
        foreach($this->mapping as $cName => $classMeta){
            if($cName === $className || \blaze\lang\String::asWrapper($cName)->endsWith($className))
                    return $classMeta;
        }

        return null;
    }

    public function getClassDescriptors() {
        return $this->mapping;
    }


}

?>
