<?php

namespace blaze\lang;

/**
 * Description of HashUtil
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author  Christian Beikov
 */
class HashUtil extends Object {

    private static $hashes = array();

    private function __construct() {

    }

    public static function getIntHash($value) {
        $value = Integer::asNative($value);
        return $value;
    }

    public static function getBooleanHash($value) {
        $value = Boolean::asNative($value);
        return $value ? 1231 : 1237;
    }

    public static function getByteHash($value) {
        $value = Byte::asNative($value);
        return $value;
    }

    public static function getCharHash($value) {
        $value = Character::asNative($value);
        return ord($value);
    }

    public static function getDoubleHash($value) {
        $value = Double::asNative($value);
        $bits = Double::doubleToLongBits($value);
        return (int) ($bits ^ ($bits >> 32));
    }

    public static function getFloatHash($value) {
        $value = Float::asNative($value);
        $bits = Float::floatToIntBits($value);
        return (int) ($bits ^ ($bits >> 32));
    }

    public static function getLongHash($value) {
        $value = Long::asNative($value);
        return (int) ($value ^ ($value >> 32));
    }

    public static function getShortHash($value) {
        $value = Short::asNative($value);
        return $value;
    }

    public static function getStringHash($value) {
        $value = String::asNative($value);
        if (!array_key_exists($value, self::$hashes)) {
            $h = 0;
            $off = 0;
            $val = $value;
            $len = strlen($value);

            for ($i = 0; $i < $len; $i++) {
                $h = 31 * $h + $val[$off++];
            }
            self::$hashes[$value] = $h;
        }

        return self::$hashes[$value];
    }

}

?>
