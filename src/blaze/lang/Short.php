<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Byte
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Short extends Number {
    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }
    public function byteValue() {

    }

    public function doubleValue() {

    }

    public function floatValue() {

    }

    public function intValue() {

    }

    public function longValue() {

    }

    public static function parse($value) {

    }

    public function shortValue() {

    }

    public function toNative() {
        return $this->value;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_int($value) && $value < 0xFFFF;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Short;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return integer
     */
    public static function asNative($value){
        if($value instanceof Short)
            return $value->value;
        else
            return Integer::asNative($value) & 0xFFFF;
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return blaze\lang\Integer
     */
    public static function asWrapper($value){
        if($value instanceof Short)
            return $value;
        else
            return new self($value);
    }
}

?>
