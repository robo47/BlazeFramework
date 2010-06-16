<?php
namespace blazeServer\source;
use blaze\lang\Object,
    blaze\lang\System,
    blaze\lang\StaticInitialization,
    blaze\io\File,
    blaze\lang\String,
    blaze\lang\ClassWrapper,
    blaze\lang\ClassLoader,
    blaze\web\Application,
    blaze\web\ApplicationContext,
    blaze\web\ApplicationError;

/**
 * Description of BlazeApplication
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author RedShadow
 * @todo    Implementation and documentation.
 */
class BlazeApplication extends Object implements StaticInitialization, Application {

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
        self::$avilableApplicationPath = new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -3)).DIRECTORY_SEPARATOR.'webapps');
        self::$runningApplicationPath = new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -2)).DIRECTORY_SEPARATOR.'webapp');
        self::$blazeServer = new self(new File(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -1))), true);
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
    public static function getCurrentApplication() {
        $request = ApplicationContext::getInstance()->getRequest();
        $dirs = $request->getRequestURI()->trim('/')->split('/');
        
        if(count($dirs) > 1 && $dirs[1] != 'blazeServer')
            return self::getApplication($dirs[1]);
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
    public static function getApplication($name) {
        $app = new File(self::$runningApplicationPath,$name);

        if($app->isChildOf(self::$runningApplicationPath) &&$app->exists())
                return new self($app,true);

        $app = new File(self::$avilableApplicationPath,$name);

        if($app->isChildOf(self::$avilableApplicationPath) && $app->exists())
                return new self($app,false);
        return null;
    }

    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getAvailableApplications(){
        $applicationDir = new File(self::$avilableApplicationPath);
        $apps = array();
        
        foreach($applicationDir->listFiles() as $app){
            $apps[] = new Application($app,true);
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
            $apps[] = new Application($app,true);
        }

        return $apps;
    }

    /**
     *
     * @return blaze\web\WebView
     */
    public function getRequestedView(){
        $request = ApplicationContext::getInstance()->getRequest();
        $response = ApplicationContext::getInstance()->getResponse();
        // remove the prefix of the url e.g. BlazeFrameworkServer/
        $reqUrl = $request->getRequestURI()->trim('/')->replace($this->url,'');

        // Requesturl has always to start with a '/'
        if($reqUrl->length() == 0 || $reqUrl->charAt(0) != '/')
            $reqUrl = new String('/'.$reqUrl->toNative());

        $navigationMap = $this->config->getNavigationMap();
        foreach ($navigationMap as $key => $value) {
            if($reqUrl->startsWith($key))
                // Returns an instance of the requested view
                return ClassWrapper::forName($this->package.'\\view\\'.$value['view'])->newInstance();
        }
        $response->sendError(HttpNetletResponse::SC_NOT_FOUND);
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
