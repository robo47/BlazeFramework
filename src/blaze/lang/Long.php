<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Long
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Long extends Number{

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }
    public function byteValue() {

    }

    public function doubleValue() {

    }

    public function floatValue() {

    }

    public function intValue() {

    }

    public function longValue() {

    }

    public static function parse($value) {

    }

    public function shortValue() {

    }

    /**
     *
     * @return double
     */
    public function toNative() {
        return $this->value;
    }
    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_long($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Long;
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
     * @param blaze\lang\Long|long $value
     * @return long
     */
    public static function asNative($value){
        return (int)parent::asNative($value);
    }

}

?>
