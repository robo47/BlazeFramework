<?php
namespace blaze\netlet\http;
use blaze\lang\Object;

/**
 * Description of HttpSessionImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class HttpSessionImpl extends Object {

    private $sessionHandler;
     private $id;
     private $sessionMap;
     private $creationTime;
     private $maxInactiveInterval;
     private $maxLifetime;
    /**
     * Beschreibung
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
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public function invalidate(){
         
     }

     public function getAttribute($name){
         array_key_exists($name, $this->sessionMap) ? $this->sessionMap[$name] : null;
     }
     public function setAttribute($name, $value){
        $this->sessionMap[$name] = $value;
     }
     public function removeAttribute($name){
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
