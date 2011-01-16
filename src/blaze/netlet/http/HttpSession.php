<?php

namespace blaze\netlet\http;

/**
 * Description of HttpSession
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface HttpSession {
    public function invalidate();

    public function getAttribute($name);

    public function setAttribute($name, $value);

    public function removeAttribute($name);

    public function getId();

    public function getSessionMap();

    public function getCreationTime();

    public function getMaxInactiveInterval();

    public function setMaxInactiveInterval(\int $maxInactiveInterval);

    public function getMaxLifetime();

    public function setMaxLifetime(\int $maxLifetime);
}

?>
