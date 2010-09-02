<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Long
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Long extends Number{

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
        return is_long($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Long;
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
     * @param blaze\lang\Long|long $value
     * @return long
     */
    public static function asNative($value){
        return parent::asNative($value);
    }

    public function hashCode(){
        return (int)($this->value ^ ($this->value >> 32));
    }


    public function equals(Reflectable $o){
        return $o instanceof Long && $o->value == $this->value;
    }

    public function compareTo(Object $obj) {
        if($obj instanceof  Long){
            return $this->toNative()-$obj->toNative();
        }
        else
        {
            throw  new ClassCastException('Integer is only compareable with Integer');
        }
    }

    public static function compare(Long $obj, Long $obj2){
         if($obj instanceof Long&& $obj2 instanceof Long){
             return $obj->toNative()-$obj2->toNative();
        }
        else
        {
            throw  new ClassCastException('Long is only compareable with Long');
        }
    }

    public static function valueOf($string){

    }

     public static function toHexString($i){
        return dechex($i);
    }
    public static function toBinaryString($i){
        return \decbin($i);
    }
    public static  function toOctal($i){
        return \decoct($i);
    }

}

?>
