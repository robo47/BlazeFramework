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
 */
class Float extends Number implements Comparable {

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }
    public function byteValue() {
        return Byte::asNative($this->value);
    }

   public function doubleValue() {
        return Double::asNative($this->value);
    }

    public function floatValue() {
        return Float::asNative($this->value);
     }

    public function intValue() {
        return Integer::asNative($this->value);
    }

    public function longValue() {
        return Long::asNative($this->value);
    }

    public static function parse($value) {
        $this->value = self::asNative($value);
    }

    public function shortValue() {
        return Short::asNative($this->value);
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

    public function compareTo(Object $obj) {
        if($obj === null)
            throw new NullPointerException();
        if($obj instanceof Float)
            return $this->value - $obj->value < 0 ? -1 : ($this->value - $obj->value > 0 ? 1 : 0);
        throw new ClassCastException('Could not cast '.$obj->getClass()->getName().' to Float.');
    }
    public static function  intBitsToFloat($bits){

    }

    public static function valueOf($string){

    }
}

?>
