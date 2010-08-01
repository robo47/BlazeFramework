<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of TimeZone
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
