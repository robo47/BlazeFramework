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
class SessionFactoryImpl extends Object implements \blaze\persistence\SessionFactory{

    private $properties;
    private $ressources;
    private $sessions;
    private $ds;
    private $dialect;
    private $mapping = array();

    public function __construct(\blaze\collections\map\Properties $properties, \blaze\collections\lists\ArrayList $ressources){
        $driverName = $properties->getProperty('persistence.connection.datasource.class');

        if($driverName != null){
            $dsClass = \blaze\lang\ClassWrapper::forName($driverName);
            $dsHost = $properties->getProperty('persistence.connection.datasource.host');
            $dsPort = $properties->getProperty('persistence.connection.datasource.port');
            $dsDatabase = $properties->getProperty('persistence.connection.datasource.database');
            $dsUsername = $properties->getProperty('persistence.connection.datasource.username');
            $dsPassword = $properties->getProperty('persistence.connection.datasource.password');
            $dsOptions = $properties->getProperty('persistence.connection.datasource.options');
            $this->ds = $dsClass->getMethod('getDataSource')->invokeArgs(null, array($dsHost, $dsPort, $dsDatabase, $dsUsername, $dsPassword, $dsOptions));
        }else{
            $dsn = $properties->getProperty('persistence.connection.datasource.url');
            $dsUsername = $properties->getProperty('persistence.connection.datasource.username');
            $dsPassword = $properties->getProperty('persistence.connection.datasource.password');
            $dsOptions = $properties->getProperty('persistence.connection.datasource.options');
            $this->ds = \blaze\ds\DataSourceManager::getInstance()->getDataSource($dsn, $dsUsername, $dsPassword, $dsOptions);
        }

//        $dialectClass = \blaze\lang\ClassWrapper::forName($properties->getProperty('persistence.dialect'));
//        $this->dialect = $dialectClass->getMethod('getDialect')->invokeArgs(null, array());

        foreach($ressources as $ressource){
            $this->loadMapping($ressource);
        }

        $this->properties = $properties;
        $this->ressources = $ressources;
        $this->sessions = new \blaze\collections\lists\ArrayList();
    }

    public function close() {
        foreach($this->sessions as $session){
            $session->close();
        }
    }

    public function openSession() {
        $sess = new SessionImpl();
        $this->sessions->add($sess);
        return $sess;
    }

    private function loadMapping(\blaze\io\File $file){
        $doc = new \DOMDocument();
        $doc->load($file->getAbsolutePath());

        if($doc->documentElement->localName != 'persistence-mapping')
            throw new \Exception('The first element must be of the type persistence-mapping');
        $class = new \blaze\persistence\tool\metainfo\ClassMetaInfo();
        $class->fromXml($doc->documentElement->firstChild);
        $this->mapping[] = $class;
    }
    
}

?>
