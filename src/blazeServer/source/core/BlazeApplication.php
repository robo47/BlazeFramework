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
    blaze\web\application\ApplicationContext;

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
    private $request;
    private $response;
    private $navigationHandler;
    private $defaultLocale;
    private $converter;
    private $validator;

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    public function __construct(\blazeServer\source\netlet\NetletApplication $netletApplication, \blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response){
        $this->netletApplication = $netletApplication;
        $this->request = $request;
        $this->response = $response;
        $this->navigationHandler = new \blaze\web\application\NavigationHandler($this->getConfig()->getNavigationMap(), $request->getRequestURI()->getPath());
        $this->converter = array();
        $this->validator = array();
    }

    public function addConverter($name, $class) {
        $this->converter[$name] = $class;
    }

    public function addValidator($name, $class) {
        $this->validator[$name] = $class;
    }

    /**
     *
     * @return blaze\util\Locale
     */
    public function getDefaultLocale() {
        return $this->defaultLocale;
    }

    public function setDefaultLocale(\blaze\util\Locale $locale) {
        $this->defaultLocale = $locale;
    }

    /**
     * @return blaze\web\application\NavigationHandler
     */
    public function getNavigationHandler() {
        return $this->navigationHandler;
    }
    
    public function setNavigationHandler(\blaze\web\application\NavigationHandler $handler) {
        $this->navigationHandler = $handler;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->netletApplication->getName();
    }
    /**
     *
     * @return blaze\web\application\WebConfig
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
    public function getUrlPrefix() {
        return $this->netletApplication->getUrlPrefix();
    }
}
?>
