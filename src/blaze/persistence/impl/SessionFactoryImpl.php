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
class SessionFactoryImpl extends Object implements \blaze\persistence\SessionFactory {

    private $properties;
    private $ressources;
    private $ds;
    private $dialect;
    private $mapping = array();
    private $freeConnections;
    private $usedConnections;

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

//        $dialectClass = \blaze\lang\ClassWrapper::forName($properties->getProperty('persistence.dialect'));
//        $this->dialect = $dialectClass->getMethod('getDialect')->invokeArgs(null, array());

        foreach ($ressources as $ressource) {
            $this->loadMapping($ressource);
        }

        $this->properties = $properties;
        $this->ressources = $ressources;
        $this->freeConnections = new \blaze\collections\queue\Stack();
        $this->usedConnections = new \blaze\collections\map\HashMap();
    }

    public function close() {
        $iter = $this->usedConnections->getIterator();

        while ($iter->hasNext()) {
            $entry = $iter->next();
            $session = $entry->getKey();

            if ($session != null && !$session->isClosed()) {
                $con = $entry->getValue();
                $session->close();
                $this->freeConnections->push($con);
                $iter->remove();
            }
        }
    }

    public function openSession() {
        $con = null;

        if ($this->freeConnections->count() == 0) {
            $this->freeClosedSessions();

            if ($this->freeConnections->count() == 0)
                $con = $this->ds->getConnection();
            else
                $con = $this->freeConnections->pop();
        }else {
            $con = $this->freeConnections->pop();
        }

        $sess = new SessionImpl($con, $this, $this->mapping);
        $this->usedConnections->put($sess, $con);
        return $sess;
    }

    private function freeClosedSessions() {
        $iter = $this->usedConnections->getIterator();

        while ($iter->hasNext()) {
            $entry = $iter->next();
            $session = $entry->getKey();

            if ($session != null && $session->isClosed()) {
                $con = $entry->getValue();
                $this->freeConnections->push($con);
                $iter->remove();
            }
        }
    }

    private function loadMapping(\blaze\io\File $file) {
        $doc = new \DOMDocument();
        $doc->load($file->getAbsolutePath());

        if ($doc->documentElement->localName != 'persistence-mapping')
            throw new \Exception('The first element must be of the type persistence-mapping');
        $class = new \blaze\persistence\tool\metainfo\ClassMetaInfo();
        $class->fromXml($doc->documentElement->firstChild);
        $fullClassName = $class->getPackage().'\\'.$class->getName();
        $this->mapping[$fullClassName] = $class;
    }

    public function getClassMetaByString($className){
        foreach($this->mapping as $cName => $classMeta){
            if($cName === $className || \blaze\lang\String::asWrapper($cName)->endsWith($className))
                    return $classMeta;
        }

        return null;
    }

    /**
     *
     * @param \blaze\lang\Object $o
     * @return blaze\persistence\tool\metainfo\ClassMetaInfo
     */
    public function getClassMeta(\blaze\lang\Object $o) {
        if($o === null)
            throw new \blaze\lang\NullPointerException();

        $name = $o->getClass()->getName()->toNative();
        if(array_key_exists($name, $this->mapping))
                return $this->mapping[$name];
        else
            return null;
    }

}

?>
