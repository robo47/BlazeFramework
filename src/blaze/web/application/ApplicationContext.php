<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper;

/**
 * The ApplicationContext contains information about a request and is only for
 * the time until a response is made available.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ApplicationContext extends Object {

    private static $instance;
    private $request;
    private $response;
    private $application;
    private $elContext;
    private $attributes;

    // See FacesContext

    public function __construct(Application $application, \blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response) {
        self::$instance = $this;
        $this->application = $application;
        $this->request = $request;
        $this->response = $response;

        $conf = $this->application->getConfig()->getNetletConfigurationMap();
        $variableMapper = new \blaze\util\HashMap();

        foreach ($conf['beacons'] as $beacon) {
            $variableMapper->set($beacon['name'], \blaze\lang\ClassWrapper::forName($beacon['class'])->newInstance());
        }

        $this->elContext = new \blaze\web\el\ELContext($variableMapper);
    }

    public function getAttribute($name) {
        if (!array_key_exists($name, $this->attributes))
            return null;
        return $this->attributes[$name];
    }

    public function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function removeAttribute($name) {
        unset($this->attributes[$name]);
    }

    /**
     *
     * @return blaze\web\http\HttpNetletRequest
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     *
     * @return blaze\web\http\HttpNetletResponse
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Return the ApplicationContext instance for the request that is being processed by the current thread.
     *
     * @return blaze\web\application\ApplicationContext
     */
    public static function getCurrentInstance() {
        // No threads available, so the instance is a singleton instance
        return self::$instance;
    }

    /**
     *
     * @return blaze\web\application\Application
     */
    public function getApplication() {
        return $this->application;
    }

    /**
     *
     * @return blaze\web\el\ELContext
     */
    public function getELContext() {
        return $this->elContext;
    }

}
?>
