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
 blaze\web\application\BlazeContext;

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
    private $elContext;
    private $viewHandler;
    private $navigationHandler;
    private $defaultLocale;
    private $navigationCases = array();
    private $converter = array();
    private $validator = array();
    private $renderKitFactories = array();

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    public function __construct(\blazeServer\source\netlet\NetletApplication $netletApplication) {
        $this->netletApplication = $netletApplication;
        $this->init();
    }

    private function init(){
        $confMap = $this->getConfig()->getConfigurationMap();

        // Taglibraries
        foreach($confMap['taglibs'] as $componentFamily => $options){
            $this->renderKitFactories[$componentFamily] = ClassWrapper::forName($options['renderKitFactory'])->getMethod('getInstance')->invoke(null, null);

            foreach ($options['renderKits'] as $renderKitId => $renderKit) {
                $this->renderKitFactories[$componentFamily]->addRenderKit($componentFamily, $renderKitId, ClassWrapper::forName($renderKit)->newInstance());
            }
        }

        // ManagedNuts
        $variableMapper = new \blaze\util\HashMap();
        foreach ($confMap['nuts'] as $nut) {
            $variableMapper->set($nut['name'], \blaze\lang\ClassWrapper::forName($nut['class'])->newInstance());
        }

        // NavigationRules
//        foreach($confMap['navigation'] as $navLocation => $options){
//
//        }
        $this->navigationCases = $confMap['navigation'];

        $this->elContext = new \blaze\web\el\ELContext($variableMapper);
        $this->navigationHandler = new \blaze\web\application\NavigationHandler($this->navigationCases);
        $this->viewHandler = new \blaze\web\application\ViewHandler($confMap['views'], $this->navigationCases);
    }

    public function addConverter($name, $class) {
        $this->converter[$name] = $class;
    }

    public function addValidator($name, $class) {
        $this->validator[$name] = $class;
    }

    public function addNavigationCase($uri, $defaultViewId, $binds, $actions){

    }

    public function getRenderKitFactory($componentFamily) {
        return $this->renderKitFactories[$componentFamily];
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
     *
     * @return blaze\web\el\ELContext
     */
    public function getELContext() {
        return $this->elContext;
    }

    /**
     *
     * @return \blaze\web\application\ViewHandler
     */
    public function getViewHandler() {
        return $this->viewHandler;
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
