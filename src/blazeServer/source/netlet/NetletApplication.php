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

    const SERVER_HOME = 'BlazeFrameworkServer/';
    /**
     *
     * @var array
     */
    private static $serverConfig;
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
     * @var blaze\web\application\WebConfig
     */
    private $config;
    /**
     *
     * @var blaze\lang\String
     */
    private $package;
    private $netletContext;

    public static function staticInit() {
        self::$serverConfig = \blazeServer\ServerConfig::getInstance()->getConfig();
        self::$blazeServer = new self('blazeServer', self::$serverConfig['applications']['blazeServer']['name'],'/BlazeFrameworkServer/server/', true);
    }

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    private function __construct($package, $name, $urlPrefix, $running){
        $this->package = String::asWrapper($package);
        $this->name = String::asWrapper($name);
        $this->urlPrefix = String::asWrapper($urlPrefix);
        $this->running = $running;

        if(self::$blazeServer == null){
            // Used by staticInit()
            $this->package = new String('blazeServer');
            $this->urlPrefix = new String(self::SERVER_HOME.'blazeServer');
        }

        $this->config = ClassWrapper::forName($this->package.'\\Config')->getMethod('getInstance')->invoke(null,null);
        $this->initApplication();
    }

    public function initApplication(){
        $conf = $this->config->getNetletConfigurationMap();
        $this->netletContext = new NetletContextImpl($conf['initParams'], $this);

        foreach($conf['netlets'] as $netlet){
            $netletConfig = new NetletConfigImpl($netlet['name'], $this->netletContext, $netlet['initParams']);
            $netletInst = ClassWrapper::forName($netlet['class'])->newInstance();
            $netletInst->init($netletConfig);
            $this->netletContext->addNetlet($netlet['name'], $netletInst);
        }

        foreach($conf['netletMapping'] as $uriMapping => $name){
            $this->netletContext->addNetletMapping($uriMapping, $name);
        }

        foreach($conf['filters'] as $filter){
            $filterConfig = new FilterConfigImpl($filter['name'], $this->netletContext, $filter['initParams']);
            $filterInst = ClassWrapper::forName($filter['class'])->newInstance();
            $filterInst->init($filterConfig);
            $this->netletContext->addFilter($filter['name'], $filterInst);
        }

        foreach($conf['filterMapping'] as $uriMapping => $name){
            $this->netletContext->addFilterMapping($uriMapping, $name);
        }

        // Listeners
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

        foreach(self::$serverConfig['mappings'] as $key => $value){
            $regex = '/'.str_replace(array('/','*'), array('\/','.*'), $key).'/';

            if($uri->matches($regex)){
                return $value;
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

        foreach(self::$serverConfig['applications'] as $appPackage => $options)
            if($appPackage == $pkgName)
                return new NetletApplication($appPackage, $options['name'], $options['uriPrefix'], $options['running']);

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
        $apps = array();

        foreach(self::$serverConfig['applications'] as $appPackage => $options){
            $apps[] = new NetletApplication($appPackage, $options['name'], null, $options['running']);
        }

        return $apps;
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getRunningApplications(){
        $apps = array();

        foreach(self::$serverConfig['applications'] as $appPackage => $options){
            if($options['running'] == true)
            $apps[] = new NetletApplication($appPackage, $options['name'], null, $options['running']);
        }

        return $apps;
    }

    //-------------- GETTER ---------------------------

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
     * @return blaze\web\application\WebConfig
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
