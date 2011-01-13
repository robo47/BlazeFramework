<?php

namespace blaze\lang;

use blaze\lang\Object;

/**
 * Description of Double
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class Double extends Number implements Comparable {

    const MAX_VALUE = 1.7976931348623157e+308;
    const MIN_VALUE = -1.7976931348623157e+308;
    const MIN_POSITIVE = 10e-324;
    const MAX_NEGATIVE = -10e-324;
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
     * @return double
     */
    public function toNative() {
        return $this->value;
    }

    /**
     * If the given value is between MAX_VALUE and MAX_VALUE + 10^291 or MIN_VALUE
     * and MIN_VALUE - 10^291 it is still represented as MAX_VALUE or MIN_VALUE.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_numeric($value) && $value >= self::MIN_VALUE && $value <= self::MAX_VALUE || $value === self::NAN || $value === self::NEGATIVE_INFINITY || $value === self::POSITIVE_INFINITY;
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
    public static function asNative($value) {
        return (double) parent::asNative($value);
    }

    public static function doubleToRawLongBits($double) {
        return unpack('L', pack('d', $double));
    }

    public static function doubleToLongBits($value) {
        return self::doubleToRawLongBits($value);
    }

    public function hashCode() {
        $bits = self::doubleToLongBits($this->value);
        return (int) ($bits ^ ($bits >> 32));
    }

    public function equals(Reflectable $o) {
        return $o instanceof Double && self::doubleToLongBits($o->value) == self::doubleToLongBits($this->value);
    }

    public function compareTo(Object $obj) {

        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof Double)
            return $this->value - $obj->value < 0 ? -1 : ($this->value - $obj->value > 0 ? 1 : 0);
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Double.');
    }

    public static function valueOf($string) {
        
    }

    public static function longBitsToDouble($bits) {
        
    }

}

?>
