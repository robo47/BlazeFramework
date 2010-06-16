<?php
namespace blaze\netlet\http;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\web\ApplicationContext;

/**
 * The class HttpNetletRequestWrapper is the implementation of HttpNetletRequest
 * which encapsulates the Header data of the Http-Header.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link	http://blazeframework.sourceforge.net
 * @since	1.0
 * @version     $Revision$
 * @see 	blaze\lang\ClassWrapper
 * @author 	RedShadow
 */
class HttpNetletRequestWrapper extends Object implements HttpNetletRequest {

    private $httpHeaders = array();
    private $applicationContext;
    /**
     *
     * @var blaze\netlet\http\SessionHandler
     */
    private $sessionHandler;
    /**
     *
     * @var blaze\netlet\http\CookieHandler
     */
    private $cookieHandler;

    public function __construct() {
        $this->httpHeaders = $this->getHttpParameters();
        $this->applicationContext = ApplicationContext::getInstance();

        $this->sessionHandler = $this->applicationContext->getAttribute('blaze.web.http.SessionHandler');
        $this->cookieHandler = $this->applicationContext->getAttribute('blaze.web.http.CookieHandler');

//        $name = $this->applicationContext->getAttribute('blaze.web.http.SessionHandler');
//        $sessionHandler = new String($name != null ? $name : 'blaze.web.http.SimpleSessionHandler');
//        $name = $this->applicationContext->getAttribute('blaze.web.http.CookieHandler');
//        $cookieHandler = new String($name != null ? $name : 'blaze.web.http.SimpleCookiehandler');

        // no need to do this, already done in the deployment phase
        // standard params get prepared at deployment time
//        $sessionHandler = $sessionHandler->replace('.','\\');
//        $cookieHandler = $cookieHandler->replace('.','\\');
//        $this->sessionHandler = \blaze\lang\ClassWrapper::forName($sessionHandler);
//        $this->cookieHandler = \blaze\lang\ClassWrapper::forName($cookieHandler);


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
    public function getHost(){
        return new String($_SERVER['HTTP_HOST']);
    }
    /**
     *
     * @return array[blaze\netlet\http\Cookie]
     * @todo    maybe use AbstractFactory for cookies
     */
    public function getCookies() {
        $cookies = array();

        if($_COOKIE != null){
            foreach($_COOKIE as $key => $value)
                $cookies[] = new SimpleCookie($key, $value);
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

    public function getParameter($name) {
        if(!isset($this->httpHeaders[$name]))
                return null;
        return $this->httpHeaders[$name];
    }
    public function getParameterMap() {
        $map = new HashMap();
        $map->add($this->httpHeaders);
        return $map;
    }
    public function getParameterNames() {
        return array_keys($this->httpHeaders);
    }
    public function getParameterValues($name) {
        $values = array();
        
        if(!isset($this->httpHeaders[$name]))
            return null;
        
        if(is_array($this->httpHeaders[$name]))
            $values = $this->httpHeaders[$name];
        else
            $values[0] = $this->httpHeaders[$name];
        
        return $values;
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
        return new String($this->getScheme() . '://' . $this->getHost().$this->getRequestURI());
    }
    public function getRequestURI() {
        return new String($_SERVER['REQUEST_URI']);
    }
    public function getScheme() {
        return new String($_SERVER['HTTPS'] ? 'https' : 'http');
    }

    /**
     *
     * @return  blaze\netlet\http\Session
     * @todo    maybe use AbstractFactory for sessions
     */
    public function getSession() {
        
    }
    public function getUserAgent() {
        return new String($_SERVER['HTTP_USER_AGENT']);
    }
    public function isSecure() {
        return $_SERVER['HTTPS'];
    }
}
?>
