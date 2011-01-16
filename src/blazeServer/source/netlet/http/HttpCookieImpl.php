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
 * @since   1.0
 */
class HttpCookieImpl extends Object implements Cloneable, \blaze\netlet\http\HttpCookie{

     private $name;
     private $value;
     private $expire = null;
     private $path = null;
     private $domain = null;
     private $secure = null;
     private $httponly = null;

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

     public function setValue(\blaze\lang\String $value) {
         $this->value = $value;
     }

     public function setExpire(\int $expire) {
         $this->expire = $expire;
     }

     public function setPath(\blaze\lang\String $path) {
         $this->path = $path;
     }

     public function setDomain(\blaze\lang\String $domain) {
         $this->domain = $domain;
     }

     public function setSecure(\boolean $secure) {
         $this->secure = $secure;
     }

     public function setHttponly(\boolean $httponly) {
         $this->httponly = $httponly;
     }
}

?>
