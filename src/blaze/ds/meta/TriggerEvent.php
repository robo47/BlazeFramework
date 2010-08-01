<?php
namespace blaze\ds\meta;
use blaze\lang\Enum;

/**
 * Description of TriggerEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
