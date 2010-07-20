<?php
namespace blaze\web;

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

    /**
     *
     * @return blaze\web\Application
     */
    public static function getAdminApplication();
    /**
     *
     * @return blaze\web\Application
     */
    public static function getCurrentApplication();
    /**
     *
     * @return blaze\web\Application
     */
    public static function getApplication($name);
    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getAvailableApplications();
    /**
     * @return array Returns a list of applications which are available on this server
     */
    public static function getRunningApplications();
    /**
     * @return blaze\web\WebView
     */
    public function getRequestedView();


    /**
     * @return blaz\lang\String
     */
    public function getName();
    /**
     * @return boolean
     */
    public function getRunning();
    /**
     * @return blaze\io\File
     */
    public function getDir();
    /**
     *
     * @return blaze\web\WebConfig
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
    public function getUrl();
}
?>
