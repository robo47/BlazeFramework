<?php
namespace blaze\netlet\http;
use blaze\lang\Cloneable;

/**
 * Description of HttpCookie
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface HttpCookie extends Cloneable{

     public function __construct($name, $value);
     
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
