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
    blaze\web\ApplicationContext,
    blaze\web\ApplicationError,
    blaze\netlet\http\HttpNetletRequest;

/**
 * Description of NetletContainer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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
            $this->package = new String('\\blazeServer');
            $this->urlPrefix = new String(self::SERVER_HOME.'blazeServer');
        }

        $this->config = ClassWrapper::forName($this->package.'\\Config')->getMethod('getInstance')->invoke(null,null);
    }

    /**
     *
     * @return blaze\web\Application
     */
    public static function getApplication(HttpNetletRequest $request) {
        $uri = $request->getRequestURI()->getPath();
        $appPackage = null;
        $appPrefix = null;

        if(!$uri->endsWith('/'))
            $uri = $uri->concat('/');

        foreach(self::$serverConfig['mappings'] as $key => $value){
            $regex = '/'.str_replace(array('/','*'), array('\/','.*'), $key).'/';
            
            if($uri->matches($regex)){
                $appPackage = $value;
                $appPrefix = $key;
                break;
            }
        }
        
        $app = self::getApplicationByPackageName($appPackage);
        
        if($app != null)
            $app->urlPrefix = String::asWrapper($appPrefix);
        return $app;
    }

    /**
     *
     * @return blaze\web\Application
     */
    public static function getAdminApplication() {
        return self::$blazeServer;
    }

    /**
     *
     * @return blazeServer\source\core\NetletApplication
     */
    public static function getApplicationByPackageName($pkgName) {
        if($pkgName == null)
            return null;

        foreach(self::$serverConfig['applications'] as $appPackage => $options)
            if($appPackage == $pkgName)
                return new NetletApplication($appPackage, $options['name'], null, $options['running']);

        return null;
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getAvailableApplications(){
        $apps = array();

        foreach(self::$serverConfig['applications'] as $appPackage => $options){
            $apps[] = new NetletApplication($appPackage, $options['name'], $options['running']);
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
            $apps[] = new NetletApplication($appPackage, $options['name'], $options['running']);
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
