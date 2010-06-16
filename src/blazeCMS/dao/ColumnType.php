<?php
namespace blazeCMS\dao;
use blaze\lang\Object;
use blaze\lang\Enum;

/**
 * Description of ColumnType
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ColumnType extends Enum {
    const BOOLEAN = PDO::PARAM_BOOL;
    const INTEGER = PDO::PARAM_INT;
    const BINARY = PDO::PARAM_LOB;
    const STRING = PDO::PARAM_STR;
    const NUMERIC = PDO::PARAM_STR;
    const DATE = PDO::PARAM_STR;

    public static function getClassName() {
        return __CLASS__;
    }
}

?>
