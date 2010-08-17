<?php
namespace blaze\lang;

/**
 * Description of Boolean
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\Object
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Write a test.
 */
class Character extends Object implements NativeWrapper, Comparable {
    /**
     * @var char
     */
    private $value;

    public function __construct($value){
        parent::__construct();
        if($value instanceof String && $value->length() == 1)
            $this->value->charAt(0);
        else if(is_string($value) && strlen($value) == 1)
            $this->value = $value;
        else
            throw new IllegalArgumentException('Parameter must be a blaze\lang\String or string and may only have a length of 1');
    }

    public function toString(){
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

    public function equals(Reflectable $obj){
        if($obj instanceof Character){
            return $this->value === $obj->toNative();
        }
        return false;
    }

    public function compareTo(Object $obj) {
    }

    /**
     *
     * @param mixed $value
     * @return char
     */
    public static function asNative($value){
        if($value instanceof Character)
            return $value->value;
        
        $value = String::asNative($value);

        if(is_string($value) && strlen($value) != 0)
            return $value[0];
        return '';
    }

    /**
     *
     * @param mixed $value
     * @return blaze\lang\Character
     */
    public static function asWrapper($value){
        if($value instanceof Character)
            return $value;
        else
            return new self($value);
    }

}
?>
