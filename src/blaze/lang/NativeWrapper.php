<?php

namespace blaze\lang;

/**
 * This interface is used to wrap the native datatypes of PHP.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author  Christian Beikov
 */
interface NativeWrapper {

    /**
     * This method returns the native datatype of a wrapper class.
     *
     * @return int|float|string|boolean
     */
    public function toNative();

    /**
     * This method returns wether the given value is the native type of the class or not.
     *
     * @return boolean
     */
    public static function isNativeType($value);

    /**
     * This method returns wether the given value is the wrapper type of the class or not.
     *
     * @return boolean
     */
    public static function isWrapperType($value);

    /**
     * This method returns wether the given value is the native or wrapper type of the class or not.
     *
     * @return boolean
     */
    public static function isType($value);

    /**
     * This method returns the native datatype of a wrapper class.
     *
     * @return int|float|string|boolean
     */
    public static function asWrapper($value);

    /**
     * This method returns the native datatype of a wrapper class.
     *
     * @return int|float|string|boolean
     */
    public static function asNative($value);
}

?>
