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
class Float extends Number implements Comparable {

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }
    public function byteValue() {

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
        return Double::asNative($this->value);
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
        if($obj instanceof  Float){
            return $this->toNative()-$obj->toNative();
           
        }
        else
        {
            throw  new ClassCastException('Float is only compareable with Float');
        }
    }

    public static function compare(Integer $obj, Integer $obj2){
         if($obj instanceof Float&& $obj2 instanceof Float){
             return $obj->toNative()-$obj2->toNative();
        }
        else
        {
            throw  new ClassCastException('Float is only compareable with Float');
        }
    }
    public static function  intBitsToFloat($bits){

    }

    public static function valueOf($string){

    }
}

?>
