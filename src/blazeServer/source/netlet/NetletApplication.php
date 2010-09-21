<?php

namespace blazeServer\source\netlet;
use blaze\lang\Object,
    blaze\lang\System,
    blaze\lang\StaticInitialization,
    blaze\io\File,
    blaze\lang\String,
    blaze\lang\ClassWrapper,
    blaze\lang\ClassLoader,
    blaze\web\Application,
    blaze\web\BlazeContext,
    blaze\web\ApplicationError,
    blaze\netlet\http\HttpNetletRequest;

/**
 * Description of NetletContainer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NetletApplication extends Object implements StaticInitialization{

    /**
     *
     * @var \blaze\collections\map\HashMap
     */
    private static $serverConfig;
    /**
     *
     * @var \DOMNode
     */
    private static $defaultNetletConfig;
    /**
     *
     * @var blazeServer\source\NetletApplication
     */
    private static $blazeServer;

    /**
     *
     * @var blaze\lang\String
     */
    private $name;
    /**
     *
     * @var boolean
     */
    private $running;
    /**
     *
     * @var blaze\lang\String
     */
    private $urlPrefix;
    /**
     *
     * @var \DOMDocument
     */
    private $config;
    /**
     *
     * @var blaze\lang\String
     */
    private $package;
    private $netletContext;

    public static function staticInit() {
        self::$serverConfig = new \blaze\collections\map\HashMap();
        self::initConfig();
        self::$blazeServer = new NetletApplication('blazeServer', 'BlazeFramework Application Manager','/server', true);
        self::$serverConfig->get('applications')->add(self::$blazeServer);
    }

    private static function initConfig(){
        $f = new File(ClassLoader::getSystemClassLoader()->getClassPath(), 'blazeServer'.File::$directorySeparator.'server.xml');
        $doc = new \DOMDocument();
        $doc->load($f->getAbsolutePath());

        foreach($doc->documentElement->childNodes as $node){
            if ($node->nodeType == XML_ELEMENT_NODE) {
                switch($node->localName){
                    case 'serverHome':
                        self::$serverConfig->put('serverHome', $node->getAttribute('url'));
                        break;
                    case 'defaultNetletConfig':
                        self::$defaultNetletConfig = $node;
                        break;
                    case 'applications':
                        self::handleApplications($node);
                        break;
                }
            }
        }
    }

    private static function handleApplications($node){
        $applications = new \blaze\collections\lists\ArrayList();

        foreach($node->childNodes as $child){
            if($child->localName == 'application'){
                $package = $child->getAttribute('package');
                $name = $child->getAttribute('name');
                $running = $child->getAttribute('running') === 'true';
                $mappings = self::getMappings($child);
                $applications->add(new NetletApplication($package, $name, $mappings->get(0), $running));
            }
        }

        self::$serverConfig->put('applications', $applications);
    }

    /**
     *
     * @param string|blaze\lang\String $package
     * @param string|blaze\lang\String $name
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    private function __construct($package, $name, $urlPrefix, $running){
        $this->package = String::asWrapper($package);
        $this->name = String::asWrapper($name);
        $this->urlPrefix = String::asWrapper(self::$serverConfig->get('serverHome').trim($urlPrefix, '/'));
        $this->running = $running;

        $this->applicationPath = new File(ClassLoader::getSystemClassLoader()->getClassPath(),$package);
    }

    private function initApplication(){
        $f = new File(ClassLoader::getSystemClassLoader()->getClassPath(), $this->package.File::$directorySeparator.'web.xml');
        $doc = new \DOMDocument();
        $doc->load($f->getAbsolutePath());
        $this->config = $doc;

        $useDefault = true;

        foreach($doc->documentElement->childNodes as $node){
            if ($node->nodeType == XML_ELEMENT_NODE && $node->localName == 'netletConfig') {
                $this->netletContext = new NetletContextImpl(self::getInitParams($node), $this);
                $useDefault = false;

                self::handleConfigChildren($node);
            }
        }

        if($useDefault){
            $this->netletContext = new NetletContextImpl($this->getInitParams(self::$defaultNetletConfig), $this);
            self::handleConfigChildren(self::$defaultNetletConfig);
        }
    }

    private function handleConfigChildren($node){
        foreach($node->childNodes as $child){
            switch($child->localName){
                case 'netlets':
                    if($child->hasChildNodes())
                        $this->initNetlets($child);
                    break;
                case 'filters':
                    if($child->hasChildNodes())
                        $this->initFilters($child);
                    break;
                case 'listeners':
                    if($child->hasChildNodes())
                        $this->initListeners($child);
                    break;
            }
        }
    }

    private static function getInitParams($node){
        $initParams = new \blaze\collections\map\HashMap();

        foreach($node->childNodes as $child){
            if($child->localName == 'initParams'){
                foreach($child->childNodes as $param){
                    $initParams->put($param->getAttribute('name'), $param->getAttribute('value'));
                }
            }
        }

        return $initParams;
    }

    private static function getMappings($node){
        $mappings = new \blaze\collections\lists\ArrayList();

        foreach($node->childNodes as $child){
            if($child->localName == 'mapping'){
                    $mappings->add($child->getAttribute('pattern'));
            }
        }

        return $mappings;
    }

    private function initNetlets($node){
        foreach($node->childNodes as $child){
            if($child->localName == 'netlet'){
                $name = $child->getAttribute('name');
                $class = $child->getAttribute('class');
                $initParams = $this->getInitParams($child);

                $netletConfig = new NetletConfigImpl($name, $this->netletContext, $initParams);
                $netlet = ClassWrapper::forName($class)->newInstance();
                $netlet->init($netletConfig);
                $this->netletContext->addNetlet($name, $netlet);

                $mappings = self::getMappings($child);

                foreach($mappings as $mapping)
                    $this->netletContext->addNetletMapping($mapping, $name);
            }
        }
    }

    private function initFilters($node){
        foreach($node->childNodes as $child){
            if($child->localName == 'filter'){
                $name = $child->getAttribute('name');
                $class = $child->getAttribute('class');
                $initParams = $this->getInitParams($child);

                $filterConfig = new FilterConfigImpl($name, $this->netletContext, $initParams);
                $filter = ClassWrapper::forName($class)->newInstance();
                $filter->init($filterConfig);
                $this->netletContext->addFilter($name, $filter);

                $mappings = self::getMappings($child);

                foreach($mappings as $mapping)
                    $this->netletContext->addFilterMapping ($mapping, $name);
            }
        }
    }

    private function initListeners($node){
//        foreach($node->childNodes as $child){
//            if($child->localName == 'listener'){
//                $name = $child->getAttribute('name');
//                $class = $child->getAttribute('class');
//                $initParams = $this->getInitParams($child);
//
//                $filterConfig = new FilterConfigImpl($name, $this->netletContext, $initParams);
//                $filter = ClassWrapper::forName($class)->newInstance();
//                $filter->init($filterConfig);
//                $this->netletContext->addFilter($name, $filter);
//
//                $mappings = self::getMappings($child);
//
//                foreach($mappings as $mapping)
//                    $this->netletContext->addFilterMapping ($mapping, $name);
//            }
//        }
    }


    /**
     *
     * @param HttpNetletRequest $request
     * @return string
     */
    public static function getApplicationName(HttpNetletRequest $request) {
        $uri = $request->getRequestURI()->getPath();
        
        if(!$uri->endsWith('/'))
            $uri = $uri->concat('/');

        foreach(self::$serverConfig->get('applications') as $app){
            $regex = '/'.str_replace(array('/','*'), array('\/','.*'), $app->getUrlPrefix()).'/';
            if($uri->matches($regex)){
                return $app->getPackage();
            }
        }

        return null;
    }

    /**
     *
     * @return blazeServer\source\core\NetletApplication
     */
    public static function getApplicationByName($pkgName) {
        if($pkgName == null)
            return null;

        foreach(self::$serverConfig->get('applications') as $app){
            if($app->getPackage()->compare($pkgName) == 0){
                $app->initApplication();
                return $app;
            }
        }

        return null;
    }

    /**
     *
     * @return blaze\netlet\NetletContext
     */
    public function getNetletContext() {
        return $this->netletContext;
    }

    /**
     *
     * @return blazeServer\source\netlet\NetletApplication
     */
    public static function getAdminApplication() {
        return self::$blazeServer;
    }

    
    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getAvailableApplications(){
        foreach(self::$serverConfig->get('applications') as $app){
            $app->initApplication();
        }

        return self::$serverConfig->get('applications');
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getRunningApplications(){
        $apps = array();

        foreach(self::$serverConfig->get('applications') as $app){
            if($app->getRunning() === true){
                $app->initApplication();
                $apps[] = $app;
            }
        }

        return $apps;
    }

    //-------------- GETTER ---------------------------
    /**
     *
     * @return blaze\io\File
     */
    public function getApplicationPath() {
        return $this->applicationPath;
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->name;
    }
    /**
     *
     * @return boolean
     */
    public function getRunning() {
        return $this->running;
    }
    /**
     *
     * @return \DOMDocument
     */
    public function getConfig() {
        return $this->config;
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function getPackage() {
        return $this->package;
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function getUrlPrefix() {
        return $this->urlPrefix;
    }
}
?>
