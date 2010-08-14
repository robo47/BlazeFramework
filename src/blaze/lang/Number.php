<?php
namespace blaze\lang;

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
class Number extends Object implements StaticInitialization{

    private static $numberClasses = array();

    public static function staticInit() {
        self::$numberClasses[0] = ClassWrapper::forName('blaze\lang\Byte');
        self::$numberClasses[1] = ClassWrapper::forName('blaze\lang\Double');
        self::$numberClasses[2] = ClassWrapper::forName('blaze\lang\Float');
        self::$numberClasses[3] = ClassWrapper::forName('blaze\lang\Integer');
        self::$numberClasses[4] = ClassWrapper::forName('blaze\lang\Long');
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return blaze\lang\ClassWrapper
     */
    public static function getNumberClass($value){
        if(is_string($value)){
            if(preg_match('/^[0-9]*$/', $value))
                return self::$numberClasses[3];
            else
                return null;
        }else if(Byte::isNativeType($value) || $value instanceof Byte){
            return self::$numberClasses[0];
        }else if(Double::isNativeType($value) || $value instanceof Double){
            return self::$numberClasses[1];
        }else if(Float::isNativeType($value) || $value instanceof Float){
            return self::$numberClasses[2];
        }else if(Integer::isNativeType($value) || $value instanceof Integer){
            return self::$numberClasses[3];
        }else if(Long::isNativeType($value) || $value instanceof Long){
            return self::$numberClasses[4];
        }

        return null;
    }
}
?>
