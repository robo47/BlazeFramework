<?php
namespace blaze\netlet\http;

/**
 * Description of HttpSession
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */

interface HttpSession {
    public function __construct();

    public function invalidate();

    public function getAttribute($name);

    public function setAttribute($name, $value);

    public function removeAttribute($name);

    public function getId();

    public function getSessionMap();

    public function getCreationTime();

    public function getMaxInactiveInterval();

    public function setMaxInactiveInterval($maxInactiveInterval);

    public function getMaxLifetime();

    public function setMaxLifetime($maxLifetime);
}

?>
