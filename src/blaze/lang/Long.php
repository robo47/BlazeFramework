<?php

namespace blaze\lang;

use blaze\lang\Object;

/**
 * Description of Long
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class Long extends Number {

    const MAX_VALUE = 9223372036854775807;
    const MIN_VALUE = -9223372036854775808;
    private $value;

    public function __construct($value) {
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
     * @return double
     */
    public function toNative() {
        return $this->value;
    }

    /**
     * If the given value is between MAX_VALUE and MAX_VALUE + 1024 or MIN_VALUE
     * and MIN_VALUE - 1024 this method still returns true, because of the
     * comparison with the native datatype float.
     *
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        if(!is_numeric($value) || round($value) != $value)
            return false;
        return $value >= self::MIN_VALUE && $value <= self::MAX_VALUE;
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
    public static function asNative($value) {
        return parent::asNative($value);
    }

    public function hashCode() {
        return (int) ($this->value ^ ($this->value >> 32));
    }

    public function equals(Reflectable $o) {
        return $o instanceof Long && $o->value == $this->value;
    }

    public static function compare($obj1, $obj2) {
        if ($obj1 === null || $obj2 === null)
            return new NullPointerException();
        return self::asNative($obj1) - self::asNative($obj2);
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof Long)
            return $this->value - $obj->value;
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Long.');
    }

    public static function valueOf($string) {

    }

    public static function toHexString($i) {
        return dechex($i);
    }

    public static function toBinaryString($i) {
        return \decbin($i);
    }

    public static function toOctal($i) {
        return \decoct($i);
    }

}

?>
