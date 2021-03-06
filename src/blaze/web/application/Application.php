<?php

namespace blaze\web\application;

/**
 * Description of Application
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
interface Application {
    public function addConverter($name, $class);

    public function addValidator($name, $class);

    public function addNavigationRule(\blaze\web\application\NavigationRule $rule);

    /**
     * Returns the ELContext for the application scope
     * @return blaze\web\el\ELContext
     */
    public function getELContext();

    /**
     * @return blaze\web\application\ViewHandler
     */
    public function getViewHandler();

    /**
     * @return blaze\web\render\RendererDecorator
     */
    public function getDecorator($decoratorName);

    /**
     * @return blaze\util\Locale
     */
    public function getDefaultLocale();

    public function setDefaultLocale(\blaze\util\Locale $locale);

    /**
     * @return blaze\web\application\NavigationHandler
     */
    public function getNavigationHandler();

    public function setNavigationHandler(NavigationHandler $handler);

    /**
     * @return blaze\web\render\RenderKitFactory
     */
    public function getRenderKitFactory($componentFamily);

    /**
     * @return blaz\lang\String
     */
    public function getName();

    /**
     *
     * @return blaze\web\application\WebConfig
     */
    public function getConfig();

    /**
     *
     * @return blaze\lang\String
     */
    public function getPackage();

    /**
     *
     * @return blaze\lang\String
     */
    public function getUrlPrefix();
}

?>
