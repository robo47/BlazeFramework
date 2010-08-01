<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\ClassWrapper;

/**
 * Description of NavigationHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NavigationHandler extends Object {

    /**
     *
     * @var array
     */
    private $mapping;
    /**
     * @var string
     */
    private $requestUri;
    /**
     *
     * @var blaze\lang\String
     */
    private $action = null;
    /**
     *
     * @var blaze\web\application\WebView
     */
    private $requestedView = null;
    /**
     *
     * @var blaze\web\application\WebView
     */
    private $responseView = null;

    /**
     * Description
     */
    public function __construct($mapping) {
        $ctx = BlazeContext::getCurrentInstance();
        $this->mapping = $mapping;
        $this->requestUri = $ctx->getRequest()->getRequestUri()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$this->requestUri->endsWith('/'))
            $this->requestUri = $this->requestUri->concat('/');

        $this->requestUri = $this->requestUri->substring($ctx->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($this->requestUri->length() == 0 || $this->requestUri->charAt(0) != '/')
            $this->requestUri = new String('/' . $this->requestUri->toNative());

        foreach ($this->mapping as $key => $value) {
            if ($this->requestUri->startsWith($key)) {
                $this->requestedView = $this->responseView = ClassWrapper::forName($value['view'])->newInstance();
                break;
            }
        }
    }

    public function navigate($action) {
        $this->action = String::asWrapper($action);

        foreach ($this->mapping as $key => $value) {
            if ($this->requestUri->startsWith($key)) {
                if ($this->action != null) {
                    // Look for the action in the navigationMap
                    foreach ($value['action'] as $action) {
                        if ($this->action->compareTo($action['action']) == 0) {
                            $this->responseView = ClassWrapper::forName($action['view'])->newInstance();
                            return;
                        }
                    }
                }
            }
        }
    }

    public function getRequestView() {
        return $this->requestedView;
    }

    public function getResponseView() {
        return $this->responseView;
    }

}
?>
