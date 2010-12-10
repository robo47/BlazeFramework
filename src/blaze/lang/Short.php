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
 */
class Short extends Number {
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
     * @param blaze\lang\Integer|int $value
     * @return int
     */
    public static function asNative($value){
        return (int)parent::asNative($value) & 0xFFFF;
    }

    public function hashCode(){
        return $this->value;
    }

    public function equals(Reflectable $o){
        return $o instanceof Short && $o->value == $this->value;
    }


 public function compareTo(Object $obj) {
        if($obj instanceof  Short){
            return $this->toNative()-$obj->toNative();
        }
        else
        {
            throw  new ClassCastException('Integer is only compareable with Integer');
        }
    }

    public static function compare(Short $obj, Short $obj2){
         if($obj instanceof short&& $obj2 instanceof short){
             return $obj->toNative()-$obj2->toNative();
        }
        else
        {


        }
    }

     public static function valueOf($string){

    }
}

?>
