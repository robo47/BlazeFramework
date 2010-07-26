<?php
namespace blaze\netlet\http;
use blaze\netlet\NetletResponse;

/**
 * HttpNetletResponse capsulates a HTTP-Response which is sent to the client.
 * The Response can contain anything which is specified in the HTTP-Protocol.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface HttpNetletResponse extends NetletResponse{
    /**
     * Status code (202) indicating that a request was accepted for processing, but was not completed.
     */
    const SC_ACCEPTED = 202;
    /**
     * Status code (502) indicating that the HTTP server received an invalid response from a server it consulted when acting as a proxy or gateway.
     */
    const SC_BAD_GATEWAY = 502;
    /**
     * Status code (400) indicating the request sent by the client was syntactically incorrect.
     */
    const SC_BAD_REQUEST = 400;
    /**
     * Status code (409) indicating that the request could not be completed due to a conflict with the current state of the resource.
     */
    const SC_CONFLICT = 409;
    /**
     * Status code (100) indicating the client can continue.
     */
    const SC_CONTINUE = 100;
    /**
     * Status code (201) indicating the request succeeded and created a new resource on the server.
     */
    const SC_CREATED = 201;
    /**
     * Status code (417) indicating that the server could not meet the expectation given in the Expect request header.
     */
    const SC_EXPECTATION_FAILED = 417;
    /**
     * Status code (403) indicating the server understood the request but refused to fulfill it.
     */
    const SC_FORBIDDEN = 403;
    /**
     *     Status code (504) indicating that the server did not receive a timely response from the upstream server while acting as a gateway or proxy.
     */
    const SC_GATEWAY_TIMEOUT = 504;
    /**
     * Status code (410) indicating that the resource is no longer available at the server and no forwarding address is known. This condition SHOULD be considered permanent.
     */
    const SC_GONE = 410;
    /**
     * Status code (505) indicating that the server does not support or refuses to support the HTTP protocol version that was used in the request message.
     */
    const SC_HTTP_VERSION_NOT_SUPPORTED = 505;
    /**
     * Status code (500) indicating an error inside the HTTP server which prevented it from fulfilling the request.
     */
    const SC_INTERNAL_SERVER_ERROR = 500;
    /**
     * Status code (411) indicating that the request cannot be handled without a defined Content-Length.
     */
    const SC_LENGTH_REQUIRED = 411;
    /**
     * Status code (405) indicating that the method specified in the Request-Line is not allowed for the resource identified by the Request-URI.
     */
    const SC_METHOD_NOT_ALLOWED = 405;
    /**
     * Status code (301) indicating that the resource has permanently moved to a new location, and that future references should use a new URI with their requests.
     */
    const SC_MOVED_PERMANENTLY = 301;
    /**
     * Status code (302) indicating that the resource has temporarily moved to another location, but that future references should still use the original URI to access the resource.
     */
    const SC_MOVED_TEMPORARILY = 302;
    /**
     * Status code (300) indicating that the requested resource corresponds to any one of a set of representations, each with its own specific location.
     */
    const SC_MULTIPLE_CHOICES = 300;
    /**
     * Status code (204) indicating that the request succeeded but that there was no new information to return.
     */
    const SC_NO_CONTENT = 204;
    /**
     * Status code (203) indicating that the meta information presented by the client did not originate from the server.
     */
    const SC_NON_AUTHORITATIVE_INFORMATION = 203;
    /**
     * Status code (406) indicating that the resource identified by the request is only capable of generating response entities which have content characteristics not acceptable according to the accept headerssent in the request.
     */
    const SC_NOT_ACCEPTABLE = 406;
    /**
     * Status code (404) indicating that the requested resource is not available.
     */
    const SC_NOT_FOUND = 404;
    /**
     * Status code (501) indicating the HTTP server does not support the functionality needed to fulfill the request.
     */
    const SC_NOT_IMPLEMENTED = 501;
    /**
     * Status code (304) indicating that a conditional GET operation found that the resource was available and not modified.
     */
    const SC_NOT_MODIFIED = 304;
    /**
     * Status code (200) indicating the request succeeded normally.
     */
    const SC_OK = 200;
    /**
     * Status code (206) indicating that the server has fulfilled the partial GET request for the resource.
     */
    const SC_PARTIAL_CONTENT = 206;
    /**
     * Status code (402) reserved for future use.
     */
    const SC_PAYMENT_REQUIRED = 402;
    /**
     * Status code (412) indicating that the precondition given in one or more of the request-header fields evaluated to false when it was tested on the server.
     */
    const SC_PRECONDITION_FAILED = 412;
    /**
     * Status code (407) indicating that the client MUST first authenticate itself with the proxy.
     */
    const SC_PROXY_AUTHENTICATION_REQUIRED = 407;
    /**
     * Status code (413) indicating that the server is refusing to process the request because the request entity is larger than the server is willing or able to process.
     */
    const SC_REQUEST_ENTITY_TOO_LARGE = 413;
    /**
     * Status code (408) indicating that the client did not produce a requestwithin the time that the server was prepared to wait.
     */
    const SC_REQUEST_TIMEOUT = 408;
    /**
     * Status code (414) indicating that the server is refusing to service the request because the Request-URI is longer than the server is willing to interpret.
     */
    const SC_REQUEST_URI_TOO_LONG = 414;
    /**
     * Status code (416) indicating that the server cannot serve the requested byte range.
     */
    const SC_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    /**
     * Status code (205) indicating that the agent SHOULD reset the document view which caused the request to be sent.
     */
    const SC_RESET_CONTENT = 205;
    /**
     * Status code (303) indicating that the response to the request can be found under a different URI.
     */
    const SC_SEE_OTHER = 303;
    /**
     * Status code (503) indicating that the HTTP server is temporarily overloaded, and unable to handle the request.
     */
    const SC_SERVICE_UNAVAILABLE = 503;
    /**
     * Status code (101) indicating the server is switching protocols according to Upgrade header.
     */
    const SC_SWITCHING_PROTOCOLS = 101;
    /**
     * Status code (401) indicating that the request requires HTTP authentication.
     */
    const SC_UNAUTHORIZED = 401;
    /**
     * Status code (415) indicating that the server is refusing to service the request because the entity of the request is in a format not supported by the requested resource for the requested method.
     */
    const SC_UNSUPPORTED_MEDIA_TYPE = 415;
    /**
     * Status code (305) indicating that the requested resource MUST be accessed through the proxy given by the Location field.
     */
    const SC_USE_PROXY = 305;

    /**
     * Adds the given cookie to the response. This method can be called multiple times to set more than one cookie.
     *
     * @param 	blaze\netlet\http\Cookie $cookie
     */
     public function addCookie(Cookie $cookie);

    /**
     * Adds a header with the given name and value. The date is either a long value which represents an UNIX-Timestamp or a
     * blaze\util\Date.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\util\Date|long $value The name of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setDateHeader
     */
     public function addDateHeader($name, $value);

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setHeader
     */
     public function addHeader($name, $value);

    /**
     * Adds a header with the given name and value. This method allows response headers to have multiple values.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	integer $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:setIntHeader
     */
     public function addIntHeader($name, $value);

    /**
     * Returns a boolean which indicates if a header with the given name has
     * already been set.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @return 	boolean true if the header has already been set, otherwise false.
     */
     public function containsHeader($name);

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     //public function encodeRedirectURL($url);

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     //public function encodeURL($url);

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
     public function sendError($sc, $msg = null);

    /**
     * Sends a temporary redirect response to the client using the given
     * redirect location URL. This method can accept relative URLs;
     * If the response has already been committed, this method throws an
     * IllegalStateException. After using this method, the response should be
     * considered to be committed and should not be written to.
     *
     * @param 	blaze\lang\Object $location The redirect URL
     * @throws	blaze\io\IOException If an input or output exception occurs
     * @throws	blaze\lang\IllegalStateException If the response was committed before this method call
     */
     public function sendRedirect($location);

    /**
     * Sets a header with the given name and value. The date is either a long value which represents an UNIX-Timestamp or a
     * blaze\util\Date. If there was already a header set with the given name,
     * the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\util\Date|long $value The name of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addDateHeader
     */
     public function setDateHeader($name, $value);

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	blaze\lang\String|string $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addHeader
     */
     public function setHeader($name, $value);

    /**
     * Sets a header with the given name and value. This method allows response headers to have multiple values.
     * If there was already a header set with the given name, the new value will overwrite the old one.
     *
     * @param 	blaze\lang\String|string $name The name of the header which shall be sent
     * @param 	integer $value The value of the header which shall be sent
     * @see 	blaze\netlet\http\HttpNetletResponse:addIntHeader
     */
     public function setIntHeader($name, $value);

    /**
     * Sets the status code for this response.
     * This method is used to set the return status code when there is no error (for example, for the status codes SC_OK or SC_MOVED_TEMPORARILY).
     * If there is an error, the sendError method should be used instead.
     *
     * @param 	integer $sc The status code
     * @see 	blaze\netlet\http\HttpNetletResponse:sedError
     */
     public function setStatus($sc);

     public function flush();

     public function isCommited();

     public function reset();

     public function getContentLength();

     public function getCharacterEncoding();

     public function getLocale();

     /**
      * @return blaze\io\OutputStream
      */
     public function getOutputStream();

     /**
      * @return blaze\io\Writer
      */
     public function getWriter();

     public function setContentLength($len);

     public function setContentType($type);
     
     public function setLocale($locale);


}

?>
