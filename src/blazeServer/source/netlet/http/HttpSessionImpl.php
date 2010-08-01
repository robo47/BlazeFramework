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
 * @todo    Something which has to be done, implementation or so
 */
class HttpSessionImpl extends Object implements \blaze\netlet\http\HttpSession{

    private $sessionHandler;
     private $id;
     private $sessionMap;
     private $creationTime;
     private $maxInactiveInterval;
     private $maxLifetime;
    /**
     * Description
     */
    public function __construct(HttpSessionHandler $handler){
        $this->sessionHandler = $handler;
        $this->id = session_id();
        $this->sessionMap = $_SESSION;
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
     * @todo	Something which has to be done, implementation or so
     */
     public function invalidate(){
         session_destroy();
     }

     public function getAttribute($name){
         //return array_key_exists($name, $this->sessionMap) ? $this->sessionMap[$name] : null;
         return array_key_exists($name, $_SESSION) ? $_SESSION[$name] : null;
     }
     public function setAttribute($name, $value){
        //$this->sessionMap[$name] = $value;
        $_SESSION[$name] = $value;
     }
     public function removeAttribute($name){
        //unset($this->sessionMap[$name]);
        unset($_SESSION[$name]);
     }

     public function getId() {
         return $this->id;
     }

     public function getSessionMap() {
         //return $this->sessionMap;
         return $_SESSION;
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
