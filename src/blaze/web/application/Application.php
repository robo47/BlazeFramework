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

    /**
     * @return blaze\web\WebView
     */
    public function getView(\blaze\netlet\http\HttpNetletRequest $request);
    /**
     * @return blaze\web\WebView
     */
    public function getViewClass(\blaze\netlet\http\HttpNetletRequest $request);


    /**
     * @return blaz\lang\String
     */
    public function getName();
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
