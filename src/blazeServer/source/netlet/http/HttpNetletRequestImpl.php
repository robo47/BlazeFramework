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

    private $attributes = array();
    /**
     *
     * @var blaze\netlet\http\HttpSessionHandler
     */
    private $sessionHandler;
    private $authType;
    private $characterEncoding;
    private $characterSet;
    private $contentType;
    //private $contentLength;
    private $serverName;
    //private $serverPort;
    private $cookies;
    private $dateHeader;
    private $localAddr;
    private $localName;
    private $localPort;
    private $locale;
    private $locales;
    private $method;
    private $parameterMap;
    private $headerMap;
    private $protocol;
    private $queryString;
    private $refferer;
    private $remoteAddr;
    private $remoteHost;
    private $remotePort;
    private $remoteUser;
    private $requestPath;
    private $requestUri;
    private $scheme;
    private $userAgent;

    //private $secure;

    public function __construct() {
        
    }

    public function getAuthType() {
        if ($this->authType == null)
            $this->authType = new String($_SERVER['AUTH_TYPE']);
        return $this->authType;
    }

    public function getCharacterEncoding() {
        if ($this->characterEncoding == null)
            $this->characterEncoding = new String($_SERVER['HTTP_ACCEPT_ENCODING']);
        return $this->characterEncoding;
    }

    public function getCharacterSet() {
        if ($this->characterSet == null)
            $this->characterSet = new String($_SERVER['HTTP_ACCEPT_CHARSET']);
        return $this->characterSet;
    }

    public function getContentType() {
        if ($this->contentType == null)
            $this->contentType = new String($_SERVER['HTTP_ACCEPT']);
        return $this->contentType;
    }

    public function getContentLength() {
        return -1;
    }

    public function getServerName() {
        if ($this->serverName == null)
            $this->serverName = new String($_SERVER['HTTP_HOST']);
        return $this->serverName;
    }

    public function getServerPort() {
        return $this->isSecure() ? 443 : 80;
    }

    /**
     *
     * @return array[blaze\netlet\http\HttpCookie]
     * @todo    maybe use AbstractFactory for cookies
     */
    public function getCookies() {
        if ($this->cookies == null) {
            $this->cookies = array();

            if ($_COOKIE != null) {
                foreach ($_COOKIE as $key => $value)
                    $this->cookies[] = new HttpCookieImpl($key, $value);
            }
        }
        return $this->cookies;
    }

    public function getDateHeader() {
        if ($this->dateHeader == null)
            $this->dateHeader = new String($_SERVER['HTTP_REQUEST_TIME']);
        return $this->dateHeader;
    }

    public function getLocalAddr() {
        if ($this->localAddr == null)
            $this->localAddr = new String($_SERVER['SERVER_ADDR']);
        return $this->localAddr;
    }

    public function getLocalName() {
        if ($this->localName == null)
            $this->localName = new String($_SERVER['SERVER_NAME']);
        return $this->localName;
    }

    public function getLocalPort() {
        if ($this->localPort == null)
            $this->localPort = new String($_SERVER['SERVER_PORT']);
        return $this->localPort;
    }

    /**
     * @todo which parameters to use for the locale?
     */
    public function getLocale() {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        if ($this->locale == null)
            $this->locale = new String($_SERVER['HTTP_ACCEPT_ENCODING']);
        return $this->locale;
    }

    public function getLocales() {
        if ($this->locales == null)
            $this->locales = new String($_SERVER['HTTP_ACCEPT_ENCODING']);
        return $this->locales;
    }

    public function getMethod() {
        if ($this->method == null)
            $this->method = new String($_SERVER['REQUEST_METHOD']);
        return $this->method;
    }

    public function getParameter($name, $postType = null) {
        if ($postType === null)
            $context = $_REQUEST;
        else if ($postType === true)
            $context = $_POST;
        else
            $context = $_GET;

        if (!array_key_exists($name, $context))
            return null;
        return $context[$name];
    }

    public function getParameterMap($postType = null) {
//        if ($this->parameterMap == null) {
//            $this->parameterMap = new HashMap($_REQUEST);
//        }
//        return $this->parameterMap;
        if ($postType === null)
            $context = $_REQUEST;
        else if ($postType === true)
            $context = $_POST;
        else
            $context = $_GET;
        return $context;
    }

    /**
     * @param blaze\lang\String|string $name
     * @param mixed $o
     */
    public function setAttribute($name, $o) {
        $this->attributes[$name] = $o;
    }

    /**
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public function getAttribute($name) {
        if (!array_key_exists($name, $this->attributes))
            return null;
        return $this->attributes[$name];
    }

    /**
     * @param blaze\lang\String|string $name
     */
    public function removeAttribute($name) {
        unset($this->attributes[$name]);
    }

    public function getHeader($name) {
        return $this->getHeaderMap()->get($name);
    }

    public function getHeaderMap() {
        if ($this->headerMap == null) {
            $headers = array();

            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) == "HTTP_") {
                    $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
                    $headers[$key] = $value;
                }
            }
            $this->headerMap = new HashMap();
            $this->headerMap->add($headers);
        }
        return $this->headerMap;
    }

    public function getProtocol() {
        if ($this->protocol == null)
            $this->protocol = new String($_SERVER['SERVER_PROTOCOL']);
        return $this->protocol;
    }

    public function getQueryString() {
        if ($this->queryString == null)
            $this->queryString = new String($_SERVER['QUERY_STRING']);
        return $this->queryString;
    }

    public function getRefferer() {
        if ($this->refferer == null)
            $this->refferer = new String($_SERVER['HTTP_REFERER']);
        return $this->refferer;
    }

    public function getRemoteAddr() {
        if ($this->remoteAddr == null) {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_X_FORWARDED')) {
                $ip = getenv('HTTP_X_FORWARDED');
            } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_FORWARDED')) {
                $ip = getenv('HTTP_FORWARDED');
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $this->remoteAddr = new String($ip);
        }
        return $this->remoteAddr;
    }

    public function getRemoteHost() {
        if ($this->remoteHost == null)
            $this->remoteHost = new String($_SERVER['REMOTE_HOST']);
        return $this->remoteHost;
    }

    public function getRemotePort() {
        if ($this->remotePort == null)
            $this->remotePort = new String($_SERVER['REMOTE_PORT']);
        return $this->remotePort;
    }

    public function getRemoteUser() {
        if ($this->remoteUser == null)
            $this->remoteUser = new String($_SERVER['PHP_AUTH_USER']);
        return $this->remoteUser;
    }

    public function getRequestPath() {
        if ($this->requestPath == null)
            $this->requestPath = new String($this->getScheme() . '://' . $this->getServerName() . $_SERVER['REQUEST_URI']);
        return $this->requestPath;
    }

    public function getRequestURI() {
        if ($this->requestUri == null)
            $this->requestUri = \blaze\net\URI::parseURI($this->getRequestPath());
        return $this->requestUri;
    }

    public function getScheme() {
        if ($this->scheme == null)
            $this->scheme = new String(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https' : 'http');
        return $this->scheme;
    }

    /**
     *
     * @return  blaze\netlet\http\Session
     * @todo    maybe use AbstractFactory for sessions
     */
    public function getSession($create = false) {
        if ($this->sessionHandler == null)
            $this->sessionHandler = HttpSessionHandlerImpl::getInstance();
        return $this->sessionHandler->getCurrentSession($this->getCookies(), $create);
    }

    public function getSessionHandler() {
        if ($this->sessionHandler == null)
            $this->sessionHandler = HttpSessionHandlerImpl::getInstance();
        return $this->sessionHandler;
    }

    public function getUserAgent() {
        if ($this->userAgent == null)
            $this->userAgent = new HttpUserAgentImpl($_SERVER['HTTP_USER_AGENT']);
        return $this->userAgent;
    }

    public function isSecure() {
        return $_SERVER['HTTPS'];
    }

}

?>
