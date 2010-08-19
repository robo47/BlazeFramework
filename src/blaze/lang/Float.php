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
class Float extends Number {

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
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    /**
     *
     * @param blaze\lang\Float|float $value
     * @return float
     */
    public static function asNative($value){
        return (float)parent::asNative($value);
    }

    public static function floatToRawIntBits($float){
        return unpack('I',pack('f',$float));
    }
    public static function floatToIntBits($value) {
	return self::floatToRawIntBits($value);
    }

    public function hashCode(){
        $bits = self::floatToIntBits($this->value);
	return (int)($bits ^ ($bits >> 32));
    }

    public function equals(Reflectable $o){
        return $o instanceof Float && self::floatToIntBits($o->value) == self::floatToIntBits($this->value);
    }
}

?>
