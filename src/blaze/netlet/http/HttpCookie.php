<?php
namespace blaze\netlet\http;
use blaze\lang\Cloneable;

/**
 * Description of HttpCookie
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface HttpCookie extends Cloneable{

     public function getName();

     public function getValue();

     public function getExpire();

     public function getPath();

     public function getDomain();

     public function getSecure();

     public function getHttponly();

     public function setValue($value);

     public function setExpire($expire);

     public function setPath($path);

     public function setDomain($domain);

     public function setSecure($secure);

     public function setHttponly($httponly);
}

?>
