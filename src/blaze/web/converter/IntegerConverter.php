<?php
namespace blaze\web\converter;
use blaze\lang\Object,
    blaze\lang\Integer,
    blaze\lang\String,
    blaze\util\Map;

/**
 * Description of IntegerConverter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class IntegerConverter implements Converter{
    public function toObject(\blaze\web\application\BlazeContext $context, $string) {
        return Integer::asNative($string);
    }

    public function toString(\blaze\web\application\BlazeContext $context, $obj) {
        return String::asWrapper($obj);
    }

}

?>
