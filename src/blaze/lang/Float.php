<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Float
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Float;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return $this->isNativeType($value) || $this->isWrapperType($value);
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
