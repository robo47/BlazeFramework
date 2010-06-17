<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of TimeZone
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class TimeZone extends Object {


    public static function getDefault(){
        return new self();
    }

    public static function getTimeZone($identifier){
        return new self();
    }
}

?>
