<?php
namespace blaze\sql\meta;
use blaze\lang\Enum;

/**
 * Description of TriggerEvent
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
final class TriggerEvent extends Enum {

    const INSERT = 1,
          UPDATE = 2,
          DELETE = 3;

    public static function getClassName() {
        return __CLASS__;
    }
}

?>
