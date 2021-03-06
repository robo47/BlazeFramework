<?php

namespace blaze\lang;

/**
 * Description of Boolean
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author  Christian Beikov
 * @todo    Extend, http://commons.apache.org/lang/api-2.4/org/apache/commons/lang/CharUtils.html
 */
class Character extends Object implements NativeWrapper, Comparable {

    const MAX_VALUE = "\xFF";
    const MIN_VALUE = "\x0";
    /**
     * @var char
     */
    private $value;

    public function __construct($value) {
        if ($value instanceof String && $value->length() == 1)
            $this->value->charAt(0);
        else if (is_string($value) && strlen($value) == 1)
            $this->value = $value;
        else
            throw new IllegalArgumentException('Parameter must be a blaze\lang\String or string and may only have a length of 1');
    }

    public function toString() {
        return $this->value;
    }

    public function charValue() {
        return $this->value;
    }

    /**
     *
     * @return string
     */
    public function toNative() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_string($value) && strlen($value) == 1;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Character;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof Character)
            return strcmp($this->value, $obj->value);
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to Character.');
    }

    public static function isLetter(\char $char) {
        return ctype_alpha($char);
    }

    /**
     *
     * @param mixed $value
     * @return char
     */
    public static function asNative($value) {
        if ($value instanceof Character)
            return $value->value;

        $value = String::asNative($value);

        if (is_string($value) && strlen($value) != 0)
            return $value[0];
        return '';
    }

    /**
     *
     * @param mixed $value
     * @return blaze\lang\Character
     */
    public static function asWrapper($value) {
        if ($value instanceof Character)
            return $value;
        else
            return new self($value);
    }

    public function hashCode() {
        return ord($this->value);
    }

    public function equals(Reflectable $o) {
        return $o instanceof Character && $o->value == $this->value;
    }

}

?>
