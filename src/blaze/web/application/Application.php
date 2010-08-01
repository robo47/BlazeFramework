<?php
namespace blaze\web\application;

/**
 * Description of String
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
interface Application {

    public function addConverter($name, $class);
    public function addValidator($name, $class);
    // EL scopes?

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
     * @return array[blaze\web\render\RenderKitFactory]
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
