<?php
namespace blaze\netlet\http;
use blaze\netlet\NetletRequest;

/**
 * The class HttpNetletRequest encapsulates the Header data of the Http-Header.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link	http://blazeframework.sourceforge.net
 * @since	1.0
 * @version     $Revision$
 * @see 	blaze\lang\ClassWrapper
 * @author 	RedShadow
 * @todo        Documenting.
 */
interface HttpNetletRequest extends NetletRequest{
    /**
     *
     */
    public function getAuthType();
    /**
     * Returns the user agent of the client.
     *
     * @return blaze\lang\String
     */
    public function getUserAgent();
    /**
     * Returns the cookies of the request
     *
     * @return array[blaze\netlet\http\Cookie]
     */
    public function getCookies();
    /**
     * Returns the http host.
     * 
     * @return blaze\lang\String
     */
    public function getHost();
    /**
     * @return blaze\netlet\http\Session
     */
    public function getSession();
    /**
     * Returns the date and time when the message was sent.
     *
     * @return long
     */
    public function getDateHeader();
    /**
     * Returns the method which is used for the request.
     *
     * @return blaze\lang\String
     */
    public function getMethod();
    /**
     * Returns the refferer of the client.
     *
     * @return blaze\lang\String
     */
    public function getRefferer();
    /**
     * Returns the requested path of the client.
     *
     * @return blaze\lang\String
     */
    public function getRequestPath();
    /**
     * Returns the query string of the URL
     * E.g. URL: http://www.blazebit.com/?my=test&you=understand
     * The query string is of that is my=test&you=understand
     *
     * @return blaze\lang\String
     */
    public function getQueryString();
    /**
     * Returns the login of the user which is making this request
     * or null if no user is given.
     * @return blaze\lang\String
     */
    public function getRemoteUser();
    /**
     * Returns an URI for the http request.
     *
     * @return blaze\lang\String
     */
    public function getRequestURI();
    /**
     * @return blaze\lang\String
     */
    public function getCharacterEncoding();
    /**
     * @return integer
     */
    public function getCharacterSet();
    /**
     * @return blaze\lang\String
     */
    public function getContentType();
    /**
     * @return blaze\lang\String
     */
    public function getLocalAddr();
    /**
     * @return blaze\lang\String
     */
    public function getLocalName();
    /**
     * @return integer
     */
    public function getLocalPort();
    /**
     * @param blaze\lang\String|string $name
     * @return blaze\lang\String
     */
    public function getParameter($name);
    /**
     * @return array[blaze\lang\String]
     */
    public function getParameterNames();
    /**
     * @param blaze\lang\String|string $name
     * @return array[blaze\lang\String]
     */
    public function getParameterValues($name);
    /**
     * @return blaze\util\Map
     */
    public function getParameterMap();
    /**
     * @return blaze\lang\String
     */
    public function getProtocol();
    /**
     * @return blaze\lang\String
     */
    public function getScheme();
    /**
     * @return blaze\lang\String
     */
    public function getRemoteAddr();
    /**
     * @return blaze\lang\String
     */
    public function getRemoteHost();
    /**
     * @return integer
     */
    public function getRemotePort();
//    /**
//     * @param blaze\lang\String|string $name
//     * @param mixed $o
//     */
//    public function setAttribute($name, $o);
//    /**
//     * @param blaze\lang\String|string $name
//     */
//    public function removeAttribute($name);
    /**
     * @return blaze\util\Locale
     */
    public function getLocale();
    /**
     * @return array[blaze\util\Locale]
     */
    public function getLocales();
    /**
     * @return boolean
     */
    public function isSecure();
}
?>
