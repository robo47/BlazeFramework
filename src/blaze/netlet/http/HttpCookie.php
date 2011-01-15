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
interface HttpCookie extends Cloneable {
    public function getName();

    public function getValue();

    public function getExpire();

    public function getPath();

    public function getDomain();

    public function getSecure();

    public function getHttponly();

    public function setValue(\blaze\lang\String $value);

    public function setExpire(\int $expire);

    public function setPath(\blaze\lang\String $path);

    public function setDomain(\blaze\lang\String $domain);

    public function setSecure(\boolean $secure);

    public function setHttponly(\boolean $httponly);
}

?>
