<?php
namespace blazeServer\source\netlet\http;
use blaze\lang\Object,
 blaze\lang\Cloneable,
    blaze\lang\String,
    blaze\lang\IllegalArgumentException;

/**
 * Description of HttpCookieImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class HttpCookieImpl extends Object implements Cloneable, \blaze\netlet\http\HttpCookie{

     private $name;
     private $value;
     private $expire;
     private $path;
     private $domain;
     private $secure;
     private $httponly;

    /**
     *
     * @param blaze\lang\String|string $name The name of the cookie
     * @param blaze\lang\String|string $value The value of the cookie
     */
    public function __construct($name, $value){
        $name = new String($name);

        if($name->startsWith('$') || $name->contains(',') ||
           $name->contains(';') || $name->contains(' '))
                throw new IllegalArgumentException('The name of a cookie can only contain alphanumeric characters but not commas, semicolons, whitespaces or begin with $ character.');

        $this->name = $name;
        $this->value = String::asWrapper($value);
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

     public function getName() {
         return $this->name;
     }

     public function getValue() {
         return $this->value;
     }

     public function getExpire() {
         return $this->expire;
     }

     public function getPath() {
         return $this->path;
     }

     public function getDomain() {
         return $this->domain;
     }

     public function getSecure() {
         return $this->secure;
     }

     public function getHttponly() {
         return $this->httponly;
     }

     public function setValue($value) {
         $this->value = $value;
     }

     public function setExpire($expire) {
         $this->expire = $expire;
     }

     public function setPath($path) {
         $this->path = $path;
     }

     public function setDomain($domain) {
         $this->domain = $domain;
     }

     public function setSecure($secure) {
         $this->secure = $secure;
     }

     public function setHttponly($httponly) {
         $this->httponly = $httponly;
     }
}

?>
