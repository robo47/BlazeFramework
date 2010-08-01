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
 * @author 	Christian Beikov
 * @todo        Documenting.
 */
interface HttpNetletRequest extends NetletRequest{
    /**
     * Returns the name of the authentication scheme used to protect the servlet.
     *
     * @return blaze\lang\String
     */
    public function getAuthType();
    /**
     * Returns the user agent of the client.
     *
     * @return blaze\netlet\http\HttpUserAgent
     */
    public function getUserAgent();
    /**
     * Returns the cookies of the request
     *
     * @return array[blaze\netlet\http\Cookie]
     */
    public function getCookies();
    /**
     * @return blaze\netlet\http\Session
     */
    public function getSession($create = false);
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
     * @return blaze\net\URI
     */
    public function getRequestURI();

    // Maybe make method getIntHeader?

    /**
     * @param blaze\lang\String|string $name
     * @return blaze\lang\String
     */
    public function getHeader($name);
    /**
     * @return blaze\util\Map
     */
    public function getHeaderMap();
}
?>
