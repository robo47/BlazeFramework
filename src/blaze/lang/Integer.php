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
class Integer extends Object implements NativeWrapper {
    private $value;
    private $digitCount;

    public function __construct($value){
        $this->value = self::asNative($value);
        $this->digitCount = 1 + floor(log10(abs($this->value)));
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
        return is_int($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Integer;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return $this->isNativeType($value) || $this->isWrapperType($value);
    }

    public function toHexString($i){
        return dechex($i);
    }

    public function subNumber($beginIndex, $endIndex = null){
        if($endIndex === null)
            $endIndex = $this->digitCount;
	if ($beginIndex < 0) {
	    throw new IndexOutOfBoundsException($beginIndex);
	}
	if ($endIndex < 0) {
	    throw new IndexOutOfBoundsException($endIndex);
	}
	if ($endIndex > $this->digitCount) {
	    throw new IndexOutOfBoundsException($endIndex);
	}
	if ($beginIndex > $endIndex) {
	    throw new IndexOutOfBoundsException($endIndex - $beginIndex);
        }

        return (int)substr($this->value, $this->digitCount - $endIndex, $endIndex - $beginIndex);
    }

    public function getDigitCount(){
        return $this->digitCount;
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return integer
     */
    public static function asNative($value){
        if($value instanceof Integer)
            return $value->value;
        else if(is_int($value))
            return $value;
        else{
            return (int)String::asNative($value);
        }
    }

    /**
     *
     * @param blaze\lang\Integer|integer $value
     * @return blaze\lang\Integer
     */
    public static function asWrapper($value){
        if($value instanceof Integer)
            return $value;
        else
            return new self($value);
    }

    public function __toString(){
        return (string)$this->value;
    }
}
?>
