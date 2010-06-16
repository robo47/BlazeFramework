<?php
namespace blazeCMS\component;

/**
 * Description of Authentification
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Authentification {
    /**
     * @return blazeCMS\model\User
     */
     public function getUser($user, $password);
}

?>
