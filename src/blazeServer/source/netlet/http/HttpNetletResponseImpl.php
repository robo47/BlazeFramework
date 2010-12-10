<?php

namespace blazeServer\source\netlet\http;

use blaze\lang\Object,
 blaze\io\OutputStreamWriter,
 blaze\netlet\NetletOutputStream;

/**
 * Description of HttpNetletResponseImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class HttpNetletResponseImpl extends Object implements \blaze\netlet\http\HttpNetletResponse {

    /**
     *
     * @var blaze\io\OutputStream
     */
    private $os;
    /**
     *
     * @var blaze\io\Writer
     */
    private $writer;
    /*
     * @var boolean
     */
    private $commited = false;

    public function __construct() {
        $this->os = new NetletOutputStream($this);
        $this->writer = new OutputStreamWriter($this->os);
    }

    /**
     * Adds the given cookie to the response. This method can be called multiple times to set more than one cookie.
     *
     * @param 	blaze\netlet\http\Cookie $cookie
     */
    public function addCookie(\blaze\netlet\http\HttpCookie $cookie) {
        setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpire(), $cookie->getPath(), $cookie->getDomain(), $cookie->getSecure(), $cookie->getHttponly());
    }

    /**
     * Adds a header with the given name and value. The date is either a long value which represents an UNIX-Timestamp or a
     * blaze\util\Date.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\util\Date|long $value The name of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setDateHeader
     */
    public function addDateHeader($name, $value) {
        if(!$value instanceof \blaze\util\Date)
            $value = \blaze\util\Date::fromUnixTime(\blaze\lang\Long::asNative($value));
        $df = new \blaze\text\DateFormat('D, d M Y H:i:s');
        $this->addHeader($name, $df->format($value));
    }

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setHeader
     */
    public function addHeader($name, $value) {
        header($name.': '.$value);
    }

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	int $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setIntHeader
     */
    public function addIntHeader($name, $value) {
        $this->addHeader($name, $value);
    }

    /**
     * Returns a boolean which indicates if a header with the given name has
     * already been set.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @return 	boolean true if the header has already been set, otherwise false.
     */
    public function containsHeader($name) {
        foreach(headers_list() as $header)
            if(stripos($header, $name) == 0)
                    return true;
        return false;
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     */
    //public function encodeRedirectURL($url){}

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     */
    //public function encodeURL($url){}

    /**
     * Sends an error response to the client using the given status code and
     * message. The server automatically creates an error page.
     * If the response has already been committed, this method throws an IllegalStateException.
     * After using this method, the response should be considered to be committed and should not be written to.
     *
     * @param 	int $sc The statuscode of the error
     * @param 	blaze\lang\String|string $msg The error message which shall be displayed
     * @throws	blaze\io\IOException If an input or output exception occurs
     * @throws	blaze\lang\IllegalStateException If the response was committed before this method call
     */
    public function sendError($sc, $msg = null) {
        $this->setStatus($sc);

        if ($msg !== null)
            $this->getWriter()->write($msg);
    }

    /**
     * Sends a temporary redirect response to the client using the given
     * redirect location URL. This method can accept relative URLs{}
     * If the response has already been committed, this method throws an
     * IllegalStateException. After using this method, the response should be
     * considered to be committed and should not be written to.
     *
     * @param 	blaze\lang\Object $location The redirect URL
     * @throws	blaze\io\IOException If an input or output exception occurs
     * @throws	blaze\lang\IllegalStateException If the response was committed before this method call
     */
    public function sendRedirect($location) {
        $this->addHeader('Location', $location);
    }

    /**
     * Sets a header with the given name and value. The date is either a long value which represents an UNIX-Timestamp or a
     * blaze\util\Date. If there was already a header set with the given name,
     * the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\util\Date|long $value The name of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addDateHeader
     */
    public function setDateHeader($name, $value) {
        $df = new \blaze\text\DateFormat('D, d M Y H:i:s');
        $this->setHeader($name, $df->format($value));
    }

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addHeader
     */
    public function setHeader($name, $value) {
        if ($value != null){
            if($this->containsHeader($name))
                header_remove($name);
            header($name . ': ' . $value);
        }else{
            header_remove($name);
        }
    }

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	int $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addIntHeader
     */
    public function setIntHeader($name, $value) {
        $this->setHeader($name, $value);
    }

    /**
     * Sets the status code for this response.
     * This method is used to set the return status code when there is no error (for example, for the status codes SC_OK or SC_MOVED_TEMPORARILY).
     * If there is an error, the sendError method should be used instead.
     *
     * @param 	int $sc The status code
     * @see 	blaze\netlet\http\HttpNetletResponse:sendError
     */
    public function setStatus($sc) {
        header('HTTP/1.1 ' . $sc);
    }

    public function flush() {
        $this->commited = true;
    }

    public function isCommited() {
        return $this->commited;
    }

    public function reset() {

    }

    public function getContentLength() {
        return $this->getHeader('Content-Length');
    }

    public function getCharacterEncoding() {

    }

    public function getLocale() {

    }

    public function getOutputStream() {
        return $this->os;
    }

    public function getWriter() {
        return $this->writer;
    }

    public function setContentLength($len) {
        header('Content-Length: ' . $len);
    }

    public function setContentType($type) {
        header('Content-Type: ' . $type);
    }

    public function setLocale($locale) {

    }

    public function getHeader($name) {
        foreach(headers_list() as $header){
            if(($pos = strpos($header, $name.': ')) !== false)
                    return substr($header, $pos);
        }
        return null;
    }

    public function getHeaders($name) {
        return $this->getHeader($name);
    }

    public function getStatus() {
        
    }

    public function getContentType() {
        return $this->getHeader('Content-Type');
    }

    public function setCharacterEncoding($charset) {
        
    }

}
?>
