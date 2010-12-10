<?php

namespace blazeServer\source\netlet\http;

use blaze\lang\Object,
 blaze\netlet\http\HttpSessionHandler;

/**
 * Description of HttpSessionImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class HttpSessionImpl extends Object implements \blaze\netlet\http\HttpSession {

    private $sessionHandler;
    private $id;
    private $sessionMap;
    private $creationTime;
    private $maxInactiveInterval;
    private $maxLifetime;
    private $valid = true;

    /**
     * Description
     */
    public function __construct(HttpSessionHandler $handler, $sessId, $sessionMap = null) {
        $this->sessionHandler = $handler;
        $this->id = $sessId;
        if ($sessionMap == null)
            $this->sessionMap = array();
        else
            $this->sessionMap = $sessionMap;
        $this->creationTime = new \blaze\util\Date();
        $this->maxInactiveInterval = 3600;
        $this->maxLifetime = 3600;
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     */
    public function invalidate() {
        $this->sessionMap = array();
        $this->valid = false;
    }

    public function isValid() {
        return $this->valid;
    }

    public function getAttribute($name) {
        if (array_key_exists($name, $this->sessionMap))
            return $this->sessionMap[$name];
        return null;
    }

    public function setAttribute($name, $value) {
        $this->sessionMap[$name] = $value;
    }

    public function removeAttribute($name) {
        unset($this->sessionMap[$name]);
    }

    public function getId() {
        return $this->id;
    }

    public function getSessionMap() {
        return $this->sessionMap;
    }

    public function getCreationTime() {
        return $this->creationTime;
    }

    public function getMaxInactiveInterval() {
        return $this->maxInactiveInterval;
    }

    public function setMaxInactiveInterval($maxInactiveInterval) {
        $this->maxInactiveInterval = $maxInactiveInterval;
    }

    public function getMaxLifetime() {
        return $this->maxLifetime;
    }

    public function setMaxLifetime($maxLifetime) {
        $this->maxLifetime = $maxLifetime;
    }

}

?>
