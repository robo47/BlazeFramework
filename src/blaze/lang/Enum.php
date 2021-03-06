<?php

namespace blaze\lang;

/**
 * Description of Enum
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author  Christian Beikov
 */
abstract class Enum extends Object {

    /**
     *
     * @return array
     */
    public static function getNames() {
        return array_keys(static::classWrapper()->getEnumConstants());
    }

    /**
     *
     * @return array
     */
    public static function getValues() {
        return array_values(static::classWrapper()->getEnumConstants());
    }

    /**
     *
     * @return array
     */
    public static function getEntries() {
        return static::classWrapper()->getEnumConstants();
    }

    /**
     *
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public static function valueOf(String $name) {
        $entries = self::getEntries();

        if (!array_key_exists($name, $entries))
            throw new IllegalArgumentException('The enum constant ' . $name . ' does not exist!');
        return $entries[$name];
    }

    /**
     *
     * @param mixed $value
     * @return string
     */
    public static function nameOf($value) {
        $entries = self::getEntries();
        $key = array_search($value, $entries);
        if ($key === false)
            throw new IllegalArgumentException('There is no  enum constant for the value' . $value);
        return $key;
    }

}

?>
