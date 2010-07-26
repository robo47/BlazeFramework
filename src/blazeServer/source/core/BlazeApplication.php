<?php
namespace blazeServer\source\core;
use blaze\lang\Object,
    blaze\lang\System,
    blaze\lang\StaticInitialization,
    blaze\io\File,
    blaze\lang\String,
    blaze\lang\ClassWrapper,
    blaze\lang\ClassLoader,
    blaze\web\application\Application,
    blaze\web\application\ApplicationContext,
    blaze\web\ApplicationError;

/**
 * Description of BlazeApplication
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
class BlazeApplication extends Object implements Application {

    private $netletApplication;

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    public function __construct(NetletApplication $netletApplication){
        $this->netletApplication = $netletApplication;
    }

    /**
     *
     * @return blaze\web\WebView
     */
    public function getView(\blaze\netlet\http\HttpNetletRequest $request){
        $class == $this->getViewClass($request);

        if($class == null)
            return null;
        
        return $class->newInstance();
    }

    public function getViewClass(\blaze\netlet\http\HttpNetletRequest $request){
        // remove the prefix of the url e.g. BlazeFrameworkServer/
        $reqUrl = $request->getRequestURI()->getPath()->trim('/')->replace($this->getUrl(),'');

        // Requesturl has always to start with a '/'
        if($reqUrl->length() == 0 || $reqUrl->charAt(0) != '/')
            $reqUrl = new String('/'.$reqUrl->toNative());

        $navigationMap = $this->getConfig()->getNavigationMap();
        foreach ($navigationMap as $key => $value) {
            if($reqUrl->startsWith($key))
                // Returns an instance of the requested view
                return ClassWrapper::forName($this->getPackage().'\\view\\'.$value['view']);
        }
        return null;
    }

    //-------------- GETTER ---------------------------

    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->netletApplication->getName();
    }
    /**
     *
     * @return blaze\io\File
     */
    public function getDir() {
        return $this->netletApplication->getDir();
    }
    /**
     *
     * @return blaze\web\WebConfig
     */
    public function getConfig() {
        return $this->netletApplication->getConfig();
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function getPackage() {
        return $this->netletApplication->getPackage();
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function getUrl() {
        return $this->netletApplication->getUrl();
    }
}
?>
