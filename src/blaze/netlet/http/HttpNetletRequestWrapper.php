<?php
namespace blaze\netlet\http;

/**
 * HttpNetletRequestWrapper is a simple pass through implementation which can
 * be used to wrap around a HttpNetletRequest and add specific behaviour.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since	1.0
 * @author 	Christian Beikov
 */
class HttpNetletRequestWrapper extends \blaze\lang\Object implements \blaze\netlet\http\HttpNetletRequest {
    /**
     *
     * @var \blaze\netlet\http\HttpNetletRequest
     */
    protected $request;

    public function __construct(\blaze\netlet\http\HttpNetletRequest $request) {
        $this->request = $request;
    }

    public function getAuthType() {
        return $this->request->getAuthType();
    }

    public function getCookies() {
        return $this->request->getCookies();
    }

    public function getDateHeader() {
        return $this->request->getDateHeader();
    }

    public function getHeader($name) {
        return $this->request->getHeader($name);
    }

    public function getHeaderMap() {
        return $this->request->getHeaderMap();
    }

    public function getMethod() {
        return $this->request->getMethod();
    }

    public function getQueryString() {
        return $this->request->getQueryString();
    }

    public function getRefferer() {
        return $this->request->getRefferer();
    }

    public function getRemoteUser() {
        return $this->request->getRemoteUser();
    }

    public function getRequestPath() {
        return $this->request->getRequestPath();
    }

    public function getRequestURI() {
        return $this->request->getRequestURI();
    }

    public function getSession($create = false) {
        return $this->request->getSession($create);
    }

    public function getUserAgent() {
        return $this->request->getUserAgent();
    }

    public function getAttribute($name) {
        return $this->request->getAttribute($name);
    }

    public function getCharacterEncoding() {
        return $this->request->getCharacterEncoding();
    }

    public function getCharacterSet() {
        return $this->request->getCharacterSet();
    }

    public function getContentLength() {
        return $this->request->getContentLength();
    }

    public function getContentType() {
        return $this->request->getContentType();
    }

    public function getLocalAddr() {
        return $this->request->getLocalAddr();
    }

    public function getLocalName() {
        return $this->request->getLocalName();
    }

    public function getLocalPort() {
        return $this->request->getLocalPort();
    }

    public function getLocale() {
        return $this->request->getLocale();
    }

    public function getLocales() {
        return $this->request->getLocales();
    }

    public function getParameter($name, $postType = null) {
        return $this->request->getParameter($name, $postType);
    }

    public function getParameterMap() {
        return $this->request->getParameterMap();
    }

    public function getProtocol() {
        return $this->request->getProtocol();
    }

    public function getRemoteAddr() {
        return $this->request->getRemoteAddr();
    }

    public function getRemoteHost() {
        return $this->request->getRemoteHost();
    }

    public function getRemotePort() {
        return $this->request->getRemotePort();
    }

    public function getScheme() {
        return $this->request->getScheme();
    }

    public function getServerName() {
        return $this->request->getServerName();
    }

    public function getServerPort() {
        return $this->request->getServerPort();
    }

    public function isSecure() {
        return $this->request->isSecure();
    }

    public function removeAttribute($name) {
        $this->request->removeAttribute($name);
    }

    public function setAttribute($name, $o) {
        $this->request->setAttribute($name, $o);
    }

}
?>
