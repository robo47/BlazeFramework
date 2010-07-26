<?php

namespace blazeServer\source\core;
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

    /**
     *
     * @var blaze\io\File
     */
    private static $runningApplicationPath;
    /**
     *
     * @var blaze\io\File
     */
    private static $avilableApplicationPath;
    /**
     *
     * @var blazeServer\source\BlazeApplication
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
     * @var blaze\io\File
     */
    private $dir;
    /**
     *
     * @var blaze\lang\String
     */
    private $url;
    /**
     *
     * @var blaze\web\WebConfig
     */
    private $config;
    /**
     *
     * @var blaze\lang\String
     */
    private $package;

    public static function staticInit() {
        self::$avilableApplicationPath = new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -4)).DIRECTORY_SEPARATOR.'webapps');
        self::$runningApplicationPath = new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -3)).DIRECTORY_SEPARATOR.'webapp');
        self::$blazeServer = new self(new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -2))), true);
    }

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    private function __construct($dir, $running){
        //parent::__construct();
        $this->name = $dir->getName();
        $this->running = $running;
        $this->dir = $dir;

        if(self::$blazeServer == null){
            $this->package = new String('\\blazeServer');
            $this->url = new String('BlazeFrameworkServer/blazeServer');
        }else{
            $this->package = new String('\\webapp\\'.$this->name->toNative());
            $this->url = new String('BlazeFrameworkServer/'.$this->name->toNative());
        }

        $this->config = ClassWrapper::forName($this->package.'\\Config')->getMethod('getInstance')->invoke(null,null);
    }

    /**
     *
     * @return blaze\web\Application
     * @todo URL Rewriting makes problems with this implementation
     *       maybe use a configuration to define a server home?
     */
    public static function getApplication(HttpNetletRequest $request) {
        $dirs = $request->getRequestURI()->getPath()->trim('/')->split('/');

        if(count($dirs) > 1 && $dirs[1] != 'blazeServer')
            return self::getApplicationByName($dirs[1]);
        return self::$blazeServer;
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
     * @return blaze\web\Application
     */
    public static function getApplicationByName($name) {
        $app = new File(self::$runningApplicationPath,$name);

        if($app->isChildOf(self::$runningApplicationPath) &&$app->exists())
                return new NetletApplication($app,true);

        $app = new File(self::$avilableApplicationPath,$name);

        if($app->isChildOf(self::$avilableApplicationPath) && $app->exists())
                return new NetletApplication($app,false);
        return null;
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getAvailableApplications(){
        $applicationDir = new File(self::$avilableApplicationPath);
        $apps = array();

        foreach($applicationDir->listFiles() as $app){
            $apps[] = new NetletApplication($app,true);
        }

        return $apps;
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getRunningApplications(){
        $applicationDir = new File(self::$runningApplicationPath);
        $apps = array();

        foreach($applicationDir->listFiles() as $app){
            $apps[] = new NetletApplication($app,true);
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
     * @return blaze\io\File
     */
    public function getDir() {
        return $this->dir;
    }
    /**
     *
     * @return blaze\web\WebConfig
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
    public function getUrl() {
        return $this->url;
    }
}
?>
