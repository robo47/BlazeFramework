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
class Double extends Number implements Comparable {

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }
    public function byteValue() {
       
    }

    public function doubleValue() {
        return new Double((double)$this->value);
    }

    public function floatValue() {
        return new Float((float)$this->value);
     }

    public function intValue() {
        return new Integer((int)$this->value);
    }

    public function longValue() {
        return new Long($this->value);
    }

    public static function parse($value) {
        $this->value = self::asNative($value);
    }

    public function shortValue() {
        return new Short($this->value);
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
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    /**
     *
     * @param blaze\lang\Double|double $value
     * @return double
     */
    public static function asNative($value){
        return (double)parent::asNative($value);
    }
    
    public static function doubleToRawLongBits($double){
        return unpack('L',pack('d',$double));
    }
    public static function doubleToLongBits($value) {
	return self::doubleToRawLongBits($value);
    }

    public function hashCode(){
        $bits = self::doubleToLongBits($this->value);
	return (int)($bits ^ ($bits >> 32));
    }

    public function equals(Reflectable $o){
        return $o instanceof Double && self::doubleToLongBits($o->value) == self::doubleToLongBits($this->value);
    }

    public function compareTo(Object $obj) {
        if($obj instanceof  Double){
             return $this->toNative()-$obj->toNative();
        }
        else
        {
            throw  new ClassCastException('Double is only compareable with Double');
        }
    }

    public static function compare(Double $obj, Double $obj2){
         if($obj instanceof  Double&& $obj2 instanceof  Double){
             return $obj->toNative()-$obj2->toNative();
        }
        else
        {
            throw  new ClassCastException('Double is only compareable with Double');
        }
    }

    public static function valueOf($string){
        
    }
    public static function  longBitsToDouble($bits){

    }
}

    


?>
