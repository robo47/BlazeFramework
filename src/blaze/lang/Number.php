<?php
namespace blaze\lang;
use blaze\math\BigInteger,
    blaze\math\BigDecimal;

/**
 * Description of Integer
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
abstract class Number extends Object implements NativeWrapper{

    private static $numberClasses = null;

    private static function lazyInit() {
        self::$numberClasses = array();
        self::$numberClasses[0] = ClassWrapper::forName('blaze\lang\Byte');
        self::$numberClasses[1] = ClassWrapper::forName('blaze\lang\Short');
        self::$numberClasses[2] = ClassWrapper::forName('blaze\lang\Double');
        self::$numberClasses[3] = ClassWrapper::forName('blaze\lang\Float');
        self::$numberClasses[4] = ClassWrapper::forName('blaze\lang\Integer');
        self::$numberClasses[5] = ClassWrapper::forName('blaze\lang\Long');
        self::$numberClasses[6] = ClassWrapper::forName('blaze\math\BigInteger');
        self::$numberClasses[7] = ClassWrapper::forName('blaze\math\BigDecimal');
    }

    /**
     *
     * @param blaze\lang\Integer|int $value
     * @return blaze\lang\ClassWrapper
     */
    public static function getNumberClass($value){
        if(self::$numberClasses == null)
            self::lazyInit();
        
        if(is_string($value)){
            if(preg_match('/^[0-9]*$/', $value))
                return self::$numberClasses[4];
            else if(preg_match('/^(-?(?:0|[1-9]\d*))(\.\d+)?([eE][-+]?\d+)?$/', $value))
                return self::$numberClasses[3];
            else
                return null;
        }else if(Byte::isNativeType($value) || $value instanceof Byte){
            return self::$numberClasses[0];
        }else if(Short::isNativeType($value) || $value instanceof Short){
            return self::$numberClasses[1];
        }else if(Double::isNativeType($value) || $value instanceof Double){
            return self::$numberClasses[2];
        }else if(Float::isNativeType($value) || $value instanceof Float){
            return self::$numberClasses[3];
        }else if(Integer::isNativeType($value) || $value instanceof Integer){
            return self::$numberClasses[4];
        }else if(Long::isNativeType($value) || $value instanceof Long){
            return self::$numberClasses[5];
        }else if(BigInteger::isNativeType($value) || $value instanceof BigInteger){
            return self::$numberClasses[6];
        }else if(BigDecimal::isNativeType($value) || $value instanceof BigDecimal){
            return self::$numberClasses[7];
        }

        return null;
    }

    public static function asNative($value) {
        if(static::isWrapperType($value))
            return $value->toNative();
        else if(static::isNativeType($value))
            return $value;
        else{
            return String::asNative($value);
        }
    }

    public static function asWrapper($value) {
        if(static::isWrapperType($value))
            return $value;
        else
            return new static($value);
    }

        /**
     * Parses a string to the native representation of the Class
     * @param string|blaze\lang\String $value
     * @throws blaze\lang\NumberFormatException
     */
    //public static abstract function parse($value);
    public abstract function byteValue();
    public abstract function doubleValue();
    public abstract function floatValue();
    public abstract function intValue();
    public abstract function longValue();
    public abstract function shortValue();
}
?>
