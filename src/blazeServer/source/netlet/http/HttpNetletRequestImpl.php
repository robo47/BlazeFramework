<?php
namespace blazeServer\source\netlet\http;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\netlet\NetletContext;

/**
 * The class HttpNetletRequestImpl is the implementation of HttpNetletRequest
 * which encapsulates the Header data of the Http-Header.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link	http://blazeframework.sourceforge.net
 * @since	1.0
 * @version     $Revision$
 * @see 	blaze\lang\ClassWrapper
 * @author 	Christian Beikov
 */
class HttpNetletRequestImpl extends Object implements \blaze\netlet\http\HttpNetletRequest {

    private $httpHeaders = array();
    private $attributes = array();
    /**
     *
     * @var blaze\netlet\http\HttpSessionHandler
     */
    private $sessionHandler;

    public function __construct() {
        $this->httpHeaders = $this->getHttpParameters();
    }

    public function getAuthType() {
        return new String($_SERVER['AUTH_TYPE']);
    }
    public function getCharacterEncoding() {
        return new String($_SERVER['HTTP_ACCEPT_ENCODING']);
    }
    public function getCharacterSet() {
        return new String($_SERVER['HTTP_ACCEPT_CHARSET']);
    }
    public function getContentType() {
        return new String($_SERVER['HTTP_ACCEPT']);
    }
    public function getContentLength() {
        return -1;
    }
    public function getServerName(){
        return new String($_SERVER['HTTP_HOST']);
    }
    public function getServerPort(){
        return $this->isSecure() ? 443 : 80;
    }
    /**
     *
     * @return array[blaze\netlet\http\HttpCookie]
     * @todo    maybe use AbstractFactory for cookies
     */
    public function getCookies() {
        $cookies = array();

        if($_COOKIE != null){
            foreach($_COOKIE as $key => $value)
                $cookies[] = new HttpCookieImpl($key, $value);
        }
        
        return $cookies;
    }
    public function getDateHeader() {
        return new String($_SERVER['HTTP_REQUEST_TIME']);
    }
    public function getLocalAddr() {
        return new String($_SERVER['SERVER_ADDR']);
    }
    public function getLocalName() {
        return new String($_SERVER['SERVER_NAME']);
    }
    public function getLocalPort() {
        return new String($_SERVER['SERVER_PORT']);
    }
    public function getLocale() {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        return new String($_SERVER['HTTP_ACCEPT_ENCODING']);
    }
    public function getLocales() {
        return new String($_SERVER['HTTP_ACCEPT_ENCODING']);
    }
    public function getMethod() {
        return new String($_SERVER['REQUEST_METHOD']);
    }

    private function getHttpParameters(){
        $headers = array();

        foreach($_SERVER as $key => $value) {
            if (substr($key,0,5)=="HTTP_") {
                $key = str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                $headers[$key]=$value;
            }
        }
        return $headers;
    }

    public function getParameter($name, $postType = null) {
        if($postType === null)
            $context = $_REQUEST;
        else if($postType === true)
            $context = $_POST;
        else
            $context = $_GET;

        if(!array_key_exists($name, $context))
                return null;
        return $context[$name];
    }
    public function getParameterMap() {
        $map = new HashMap();
        $map->add($_REQUEST);
        return $map;
    }
    /**
     * @param blaze\lang\String|string $name
     * @param mixed $o
     */
    public function setAttribute($name, $o){
        $this->attributes[$name] = $o;
    }
    /**
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public function getAttribute($name){
        if(!array_key_exists($name, $this->attributes))
                return null;
        return $this->attributes[$name];
    }
    /**
     * @param blaze\lang\String|string $name
     */
    public function removeAttribute($name){
        unset($this->attributes[$name]);
    }

    public function getHeader($name) {
        if(!array_key_exists($name, $this->httpHeaders))
                return null;
        return $this->httpHeaders[$name];
    }
    public function getHeaderMap() {
        $map = new HashMap();
        $map->add($this->httpHeaders);
        return $map;
    }

    public function getProtocol() {
        return new String($_SERVER['SERVER_PROTOCOL']);
    }
    public function getQueryString() {
        return new String($_SERVER['QUERY_STRING']);
    }
    public function getRefferer() {
        return new String($_SERVER['HTTP_REFERER']);
    }
    public function getRemoteAddr() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return new String($ip);
    }
    public function getRemoteHost() {
        return new String($_SERVER['REMOTE_HOST']);
    }
    public function getRemotePort() {
        return new String($_SERVER['REMOTE_PORT']);
    }
    public function getRemoteUser() {
        return new String($_SERVER['PHP_AUTH_USER']);
    }
    public function getRequestPath() {
        return new String($this->getScheme() . '://' . $this->getServerName().$_SERVER['REQUEST_URI']);
    }
    public function getRequestURI() {
        return \blaze\net\URI::parseURI($this->getRequestPath());
    }
    public function getScheme() {
        return new String($_SERVER['HTTPS'] ? 'https' : 'http');
    }

    /**
     *
     * @return  blaze\netlet\http\Session
     * @todo    maybe use AbstractFactory for sessions
     */
    public function getSession($create = false) {
        if($this->sessionHandler == null)
                $this->sessionHandler = HttpSessionHandlerImpl::getInstance();
        return $this->sessionHandler->getCurrentSession($create);
    }
    public function getUserAgent() {
        return new HttpUserAgentImpl($_SERVER['HTTP_USER_AGENT']);
    }
    public function isSecure() {
        return $_SERVER['HTTPS'];
    }
}
?>
