<?php

namespace blaze\netlet\http;

/**
 * HttpNetletResponseWrapper is a simple pass through implementation which can
 * be used to wrap around a HttpNetletResponse and add specific behaviour.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class HttpNetletResponseWrapper extends \blaze\lang\Object implements \blaze\netlet\http\HttpNetletResponse {

    /**
     * @var \blaze\netlet\http\HttpNetletResponse
     */
    protected $response;

    public function __construct(\blaze\netlet\http\HttpNetletResponse $response) {
        $this->response = $response;
    }

    public function addCookie(HttpCookie $cookie) {
        $this->response->addCookie($cookie);
    }

    public function addDateHeader($name, $value) {
        $this->response->addDateHeader($name, $value);
    }

    public function addHeader($name, $value) {
        $this->response->addHeader($name, $value);
    }

    public function addIntHeader($name, $value) {
        $this->response->addIntHeader($name, $value);
    }

    public function containsHeader($name) {
        return $this->response->containsHeader($name);
    }

    public function getHeader($name) {
        return $this->response->getHeader($name);
    }

    public function getHeaders($name) {
        return $this->response->getHeaders($name);
    }

    public function getStatus() {
        return $this->response->getStatus();
    }

    public function sendError($sc, $msg = null) {
        $this->response->sendError($sc, $msg);
    }

    public function sendRedirect($location) {
        $this->response->sendRedirect($location);
    }

    public function setDateHeader($name, $value) {
        $this->response->setDateHeader($name, $value);
    }

    public function setHeader($name, $value) {
        $this->response->setHeader($name, $value);
    }

    public function setIntHeader($name, $value) {
        $this->response->setIntHeader($name, $value);
    }

    public function setStatus($sc) {
        $this->response->setStatus($sc);
    }

    public function flush() {
        $this->response->flush();
    }

    public function getCharacterEncoding() {
        return $this->response->getCharacterEncoding();
    }

    public function getContentLength() {
        return $this->response->getContentLength();
    }

    public function getContentType() {
        return $this->response->getContentType();
    }

    public function getLocale() {
        return $this->response->getLocale();
    }

    public function getOutputStream() {
        return $this->response->getOutputStream();
    }

    public function getWriter() {
        return $this->response->getWriter();
    }

    public function isCommited() {
        return $this->response->isCommited();
    }

    public function reset() {
        $this->response->reset();
    }

    public function setCharacterEncoding($charset) {
        $this->response->setCharacterEncoding($charset);
    }

    public function setContentLength($len) {
        $this->response->setContentLength($len);
    }

    public function setContentType($type) {
        $this->response->setContentType($type);
    }

    public function setLocale($locale) {
        $this->response->setLocale($locale);
    }

}

?>
