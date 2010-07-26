<?php
namespace blaze\ds\meta;
use blaze\lang\Enum;

/**
 * Description of TriggerTiming
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
final class TriggerTiming extends Enum {

    const BEFORE = 1,
          AFTER = 2;

    public static function getClassName() {
        return __CLASS__;
    }
}

?>
