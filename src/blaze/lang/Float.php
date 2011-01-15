<?php

namespace blaze\lang;

use blaze\lang\Object;

/**
 * Description of Float
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class Float extends Number implements Comparable {

    const MAX_VALUE = 3.4028235e+38;
    const MIN_VALUE = -3.4028235e+38;
    const MIN_POSITIVE = 2e-149;
    const MAX_NEGATIVE = -2e-149;
    const NAN = \NAN;
    const POSITIVE_INFINITY = INF;
    const NEGATIVE_INFINITY = NINF;
    
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
     * @return float
     */
    public function toNative() {
        return $this->value;
    }

    /**
     * If the given value is between MAX_VALUE and MAX_VALUE + 10^22 or MIN_VALUE
     * and MIN_VALUE - 10^22 this method still returns true, because of the
     * blur of the float datatype.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_numeric($value) && ($value >= self::MIN_VALUE && $value <= self::MAX_VALUE) || $value === self::NAN || $value === self::NEGATIVE_INFINITY || $value === self::POSITIVE_INFINITY;
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
    public static function asNative($value) {
        return (float) parent::asNative($value);
    }

    public static function floatToRawIntBits($float) {
        return unpack('I', pack('f', $float));
    }

    public static function floatToIntBits($value) {
        return self::floatToRawIntBits($value);
    }

    public function hashCode() {
        $bits = self::floatToIntBits($this->value);
        return (int) ($bits ^ ($bits >> 32));
    }

    public function equals(Reflectable $o) {
        return $o instanceof Float && self::floatToIntBits($o->value) == self::floatToIntBits($this->value);
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof Float)
            return $this->value - $obj->value < 0 ? -1 : ($this->value - $obj->value > 0 ? 1 : 0);
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Float.');
    }

    public static function intBitsToFloat($bits) {

    }

    public static function valueOf($string) {
        
    }

}

?>
