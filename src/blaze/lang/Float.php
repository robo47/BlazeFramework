<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Float
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Float extends Object implements NativeWrapper {

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }


    /**
     *
     * @return float
     */
    public function toNative() {
        return $this->value;
    }
    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_float($value);
    }

    /**
     *
     * @param blaze\lang\Float|float $value
     * @return float
     */
    public static function asNative($value){
        if($value instanceof Float)
            return $value->value;
        else if(is_float($value))
            return $value;
        else
            return (float)String::asNative($value);
    }

    /**
     *
     * @param blaze\lang\Float|float $value
     * @return blaze\lang\Float
     */
    public static function asWrapper($value){
        if($value instanceof Float)
            return $value;
        else
            return new self($value);
    }
}

?>
