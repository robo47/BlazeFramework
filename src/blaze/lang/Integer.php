<?php

namespace blaze\lang;

/**
 * Description of Integer
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author  Christian Beikov
 */
class Integer extends Number implements Comparable {

    const MAX_VALUE = 2147483647;
    const MIN_VALUE = -2147483648;
    private $value;
    private $digitCount;

    public function __construct($value) {
        $this->value = self::asNative($value);
		if($this->value == 0)
			$this->digitCount = 1;
		else
			$this->digitCount = 1 + floor(log10(abs($this->value)));
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
        return $value instanceof Integer;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    public static function toHexString($i) {
        return String::asWrapper(dechex($i));
    }

    public static function toBinaryString($i) {
        return String::asWrapper(decbin($i));
    }

    public static function toOctal($i) {
        return String::asWrapper(decoct($i));
    }

    public static function hexStringToInt($str) {
        return String::asWrapper(hexdec($str));
    }

    public function subNumber($beginIndex, $endIndex = null) {
        if ($endIndex === null)
            $endIndex = $this->digitCount;
        if ($beginIndex < 0) {
            throw new IndexOutOfBoundsException($beginIndex);
        }
        if ($endIndex < 0) {
            throw new IndexOutOfBoundsException($endIndex);
        }
        if ($endIndex > $this->digitCount) {
            throw new IndexOutOfBoundsException($endIndex);
        }
        if ($beginIndex > $endIndex) {
            throw new IndexOutOfBoundsException($endIndex - $beginIndex);
        }

        return (int) substr($this->value, $this->digitCount - $endIndex, $endIndex - $beginIndex);
    }

    public function getDigitCount() {
        return $this->digitCount;
    }

    /**
     *
     * @param blaze\lang\Integer|int $value
     * @return int
     */
    public static function asNative($value) {
        return (int) parent::asNative($value);
    }

    public function hashCode() {
        return $this->value;
    }

    public function equals(Reflectable $o) {
        return $o instanceof Integer && $o->value == $this->value;
    }

    public function toString() {
        return (string) $this->value;
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof Integer)
            return $this->value - $obj->value;
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Integer.');
    }

    public static function valueOf($string) {
        
    }

}

?>
