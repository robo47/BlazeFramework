<?php
namespace blaze\netlet\http;
use blaze\lang\Object,
    blaze\io\OutputStreamWriter,
    blaze\netlet\NetletOutputStream;

/**
 * Description of HttpNetletResponseWrapper
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class HttpNetletResponseWrapper extends Object implements HttpNetletResponse {

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

    public function __construct() {
        $this->os = new NetletOutputStream();
        $this->writer = new OutputStreamWriter($this->os);
    }

    /**
     * Adds the given cookie to the response. This method can be called multiple times to set more than one cookie.
     *
     * @param 	blaze\netlet\http\Cookie $cookie
     */
     public function addCookie(Cookie $cookie){}

    /**
     * Adds a header with the given name and value. The date is either a long value which represents an UNIX-Timestamp or a
     * blaze\util\Date.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\util\Date|long $value The name of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setDateHeader
     */
     public function addDateHeader($name, $value){}

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setHeader
     */
     public function addHeader($name, $value){}

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	integer $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setIntHeader
     */
     public function addIntHeader($name, $value){}

    /**
     * Returns a boolean which indicates if a header with the given name has
     * already been set.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @return 	boolean true if the header has already been set, otherwise false.
     */
     public function containsHeader($name){}

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     //public function encodeRedirectURL($url){}

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     //public function encodeURL($url){}

    /**
     * Sends an error response to the client using the given status code and
     * message. The server automatically creates an error page.
     * If the response has already been committed, this method throws an IllegalStateException.
     * After using this method, the response should be considered to be committed and should not be written to.
     *
     * @param 	integer $sc The statuscode of the error
     * @param 	blaze\lang\String|string $msg The error message which shall be displayed
     * @throws	blaze\io\IOException If an input or output exception occurs
     * @throws	blaze\lang\IllegalStateException If the response was committed before this method call
     */
     public function sendError($sc, $msg = null){
         $this->setStatus($sc);
         
         if($msg !== null)
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
     public function sendRedirect($location){
         header('Location: '.$location);
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
     public function setDateHeader($name, $value){}

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addHeader
     */
     public function setHeader($name, $value){
         if($value != null)
            header($name.': '.$value);
         else
             header_remove($name);
     }

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	integer $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addIntHeader
     */
     public function setIntHeader($name, $value){}

    /**
     * Sets the status code for this response.
     * This method is used to set the return status code when there is no error (for example, for the status codes SC_OK or SC_MOVED_TEMPORARILY).
     * If there is an error, the sendError method should be used instead.
     *
     * @param 	integer $sc The status code
     * @see 	blaze\netlet\http\HttpNetletResponse:sedError
     */
     public function setStatus($sc){
         header('HTTP/1.1 '.$sc);
     }

     public function flush(){}

     public function isCommited(){}

     public function reset(){}

     public function getContentLength(){}

     public function getCharacterEncoding(){}

     public function getLocale(){}

     public function getOutputStream(){
         return $this->os;
     }

     public function getWriter(){
         return $this->writer;
     }

     public function setContentLength($len){
         header('Content-Length: '.$len);
     }

     public function setContentType($type){
         header('Content-Type: '.$type);
     }

     public function setLocale($locale){}


}

?>
