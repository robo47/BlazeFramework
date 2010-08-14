<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Double
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Double extends Object {

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }

    /**
     *
     * @return double
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
        return is_double($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Double;
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
     * @param blaze\lang\Double|double $value
     * @return double
     */
    public static function asNative($value){
        if($value instanceof Double)
            return $value->value;
        else if(is_double($value))
            return $value;
        else
            return (double)String::asNative($value);
    }

    /**
     *
     * @param blaze\lang\Double|double $value
     * @return blaze\lang\Double
     */
    public static function asWrapper($value){
        if($value instanceof Double)
            return $value;
        else
            return new self($value);
    }
}

?>
