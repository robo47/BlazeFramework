<?php

namespace blaze\lang;

use blaze\lang\Object;

/**
 * Description of Byte
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class Byte extends Number {

    const MAX_VALUE = 127;
    const MIN_VALUE = -128;
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
        return $value instanceof Byte;
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
    public static function asNative($value) {
        return (int) parent::asNative($value) & 0xFF;
    }

    public function compareTo(Object $obj) {
        if ($obj instanceof Byte)
            return $this->value - $obj->value;
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Byte.');
    }

    public function hashCode() {
        return $this->value;
    }

    public function equals(Reflectable $o) {
        return $o instanceof Byte && $o->value == $this->value;
    }

}

?>
