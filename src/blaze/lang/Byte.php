<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Byte
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Byte extends Object implements NativeWrapper {
    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
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
        return is_int($value) && $value < 0xFF;
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return integer
     */
    public static function asNative($value){
        if($value instanceof Byte)
            return $value->value;
        else
            return Integer::asNative($value) & 0xFF;
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return blaze\lang\Integer
     */
    public static function asWrapper($value){
        if($value instanceof Byte)
            return $value;
        else
            return new self($value);
    }
}

?>
