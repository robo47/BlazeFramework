<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper;

/**
 * The BlazeContext contains information about a request and is only for
 * the time until a response is made available.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class BlazeContext extends Object {

    private static $instance;
    private $request;
    private $response;
    private $application;
    private $elContext;
    private $attributes = array();
    private $messages = array();
    private $validationFailed = false;
    private $doRenderResponse = false;
    private $responseComplete = false;
    private $currentPhaseId = null;
    private $exceptionHandler = null;
    private $view = null;

    public function __construct(Application $application, \blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response) {
        self::$instance = $this;
        $this->application = $application;
        $this->request = $request;
        $this->response = $response;

        $conf = $this->application->getConfig()->getNetletConfigurationMap();
        $variableMapper = new \blaze\util\HashMap();

        foreach ($conf['nuts'] as $nut) {
            $variableMapper->set($nut['name'], \blaze\lang\ClassWrapper::forName($nut['class'])->newInstance());
        }

        $this->elContext = new \blaze\web\el\ELContext($variableMapper);
    }

    /**
     *
     * @param string|blaze\lang\String $messageId
     * @param blaze\web\application\BlazeMessage $message
     */
    public function addMessage($messageId, BlazeMessage $message) {
        $this->attributes[\blaze\lang\String::asNative($messageId)][] = $message;
    }

    /**
     *
     * @param string|blaze\lang\String $messageId
     * @return array[blaze\web\application\BlazeMessage]
     */
    public function getMessages($messageId) {
        $messageId = \blaze\lang\String::asNative($messageId);
        if (!array_key_exists($messageId, $this->messages))
            return null;
        return $this->messages[$messageId];
    }

    /**
     *
     * @param string|blaze\lang\String $name
     * @return mixed
     */
    public function getAttribute($name) {
        $name = \blaze\lang\String::asNative($name);
        if (!array_key_exists($name, $this->attributes))
            return null;
        return $this->attributes[$name];
    }

    /**
     *
     * @param string|blaze\lang\String $name
     * @param mixed $value
     */
    public function setAttribute($name, $value) {
        $this->attributes[\blaze\lang\String::asNative($name)] = $value;
    }

    /**
     *
     * @param string|blaze\lang\String $name
     */
    public function removeAttribute($name) {
        unset($this->attributes[\blaze\lang\String::asNative($name)]);
    }

    /**
     *
     * @return blaze\netlet\http\HttpNetletRequest
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     *
     * @return blaze\netlet\http\HttpNetletResponse
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Return the BlazeContext instance for the request that is being processed by the current thread.
     *
     * @return blaze\web\application\BlazeContext
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

    /**
     * Sets a flag which indicates that the conversion/validation failed.
     */
    public function validationFailed() {
        $this->validationFailed = true;
    }

    /**
     * Sets a flag which indicates that the next phase will render the response.
     */
    public function renderResponse() {
        $this->doRenderResponse = true;
    }

    /**
     * Stops the lifecycle as soon as possible. Helpfull for HTTP redirects.
     */
    public function responseComplete() {
        $this->responseComplete = true;
    }

    /**
     *
     * @return blaze\web\event\PhaseId
     */
    public function getCurrentPhaseId() {
        return $this->currentPhaseId;
    }

    /**
     *
     * @param blaze\web\event\PhaseId $currentPhaseId
     */
    public function setCurrentPhaseId($currentPhaseId) {
        $this->currentPhaseId = $currentPhaseId;
    }

    /**
     *
     * @return blaze\web\application\ExceptionHandler
     */
    public function getExceptionHandler() {
        return $this->exceptionHandler;
    }

    /**
     *
     * @param blaze\web\application\ExceptionHandler $exceptionHandler
     */
    public function setExceptionHandler(ExceptionHandler $exceptionHandler) {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     *
     * @return \blaze\web\application\WebView
     */
    public function getView() {
        return $this->view;
    }

    /**
     *
     * @param blaze\web\application\WebView $view
     */
    public function setView(\blaze\web\application\WebView $view) {
        $this->view = $view;
    }

    /**
     *
     * @return boolean
     */
    public function getValidationFailed() {
        return $this->validationFailed;
    }

    /**
     *
     * @return boolean
     */
    public function getDoRenderResponse() {
        return $this->doRenderResponse;
    }

    /**
     *
     * @return boolean
     */
    public function getResponseComplete() {
        return $this->responseComplete;
    }

}
?>
