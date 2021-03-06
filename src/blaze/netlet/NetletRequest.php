<?php

namespace blaze\netlet;

/**
 * Description of NetletRequest
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface NetletRequest {

    /**
     * @param blaze\lang\String|string $name
     * @param boolean $postType
     * @return blaze\lang\String
     */
    public function getParameter($name, $postType = null);

    /**
     * @return blaze\util\Map
     */
    public function getParameterMap();

    /**
     * @param blaze\lang\String|string $name
     * @param mixed $o
     */
    public function setAttribute($name, $o);

    /**
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * @param blaze\lang\String|string $name
     */
    public function removeAttribute($name);

    /**
     * @return blaze\lang\String
     */
    public function getCharacterEncoding();

    /**
     * @return int
     */
    public function getCharacterSet();

    /**
     * @return blaze\lang\String
     */
    public function getContentType();

    /**
     * @return int
     */
    public function getContentLength();

    /**
     * @return blaze\lang\String
     */
    public function getLocalAddr();

    /**
     * @return blaze\lang\String
     */
    public function getLocalName();

    /**
     * @return int
     */
    public function getLocalPort();

    /**
     * @return blaze\lang\String
     */
    public function getRemoteAddr();

    /**
     * @return blaze\lang\String
     */
    public function getRemoteHost();

    /**
     * @return int
     */
    public function getRemotePort();

    /**
     * @return blaze\util\Locale
     */
    public function getLocale();

    /**
     * @return array[blaze\util\Locale]
     */
    public function getLocales();

    /**
     * @return blaze\lang\String
     */
    public function getProtocol();

    /**
     * @return blaze\lang\String
     */
    public function getScheme();

    /**
     * Returns the host name of the server to which the request was sent.
     *
     * @return blaze\lang\String
     */
    public function getServerName();

    /**
     * Returns the port number to which the request was sent.
     *
     * @return int
     */
    public function getServerPort();

    /**
     * @return boolean
     */
    public function isSecure();
}

?>
