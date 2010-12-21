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
 */
class Boolean extends Object implements NativeWrapper,Comparable {
    /**
     * @var boolean
     */
    private $value;

    /**
     * Allocates a <code>Boolean</code> object representing the
     * <code>value</code> argument.
     *
     * <p><b>Note: It is rarely appropriate to use this constructor.
     * Unless a <i>new</i> instance is required, the static factory
     * {@link #valueOf(boolean)} is generally a better choice. It is
     * likely to yield significantly better space and time performance.</b>
     *
     * @param blaze\lang\String|boolean|string $boolean
     */
    public function __construct($value){
        parent::__construct();
        if(is_bool($value))
            $this->value = $value;
        else if($value instanceof String || is_string($value))
            $this->value = self::toBoolean($value);
        else
            throw new IllegalArgumentException('Parameter must be a blaze\lang\String, boolean or string');
    }

    /**
     * Parses the string argument as a boolean.  The <code>boolean</code>
     * returned represents the value <code>true</code> if the string argument
     * is not <code>null</code> and is equal, ignoring case, to the string
     * {@code "true"}. <p>
     * Example: {@code Boolean.parseBoolean("True")} returns <tt>true</tt>.<br>
     * Example: {@code Boolean.parseBoolean("yes")} returns <tt>false</tt>.
     *
     * @param string|blaze\lang\String     s   the <code>String</code> containing the boolean
     *                 representation to be parsed
     * @return     the boolean represented by the string argument
     * @since 1.5
     */
    public static function parseBoolean($value){
        return self::toBoolean($value);
    }

    /**
     * Returns the value of this <tt>Boolean</tt> object as a boolean
     * primitive.
     *
     * @return  the primitive <code>boolean</code> value of this object.
     */
    public function booleanValue(){
        return $this->value;
    }

    /**
     * Returns a <code>Boolean</code> with a value represented by the
     * specified string.  The <code>Boolean</code> returned represents a
     * true value if the string argument is not <code>null</code>
     * and is equal, ignoring case, to the string {@code "true"}.
     *
     * @param   s   a string.
     * @return  the <code>Boolean</code> value represented by the string.
     */
    public static function valueOf($value){
        $b = new Boolean($value);
        return $b->toNative();
    }

    /**
     * Returns a <tt>String</tt> object representing this Boolean's
     * value.  If this object represents the value <code>true</code>,
     * a string equal to {@code "true"} is returned. Otherwise, a
     * string equal to {@code "false"} is returned.
     *
     * @return  a string representation of this object.
     */
    public function toString(){
        return $this->value ? 'true' : 'false';
    }

    /**
     *
     * @return boolean
     */
    public function toNative() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_bool($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof Boolean;
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
     * Returns a hash code for this <tt>Boolean</tt> object.
     *
     * @return  the int <tt>1231</tt> if this object represents
     * <tt>true</tt>; returns the int <tt>1237</tt> if this
     * object represents <tt>false</tt>.
     */
    public function hashCode(){
        return $this->value ? 1231 : 1237;
    }

    /**
     * Returns <code>true</code> if and only if the argument is not
     * <code>null</code> and is a <code>Boolean</code> object that
     * represents the same <code>boolean</code> value as this object.
     *
     * @param   obj   the object to compare with.
     * @return  <code>true</code> if the Boolean objects represent the
     *          same value; <code>false</code> otherwise.
     */
    public function equals(Reflectable $obj){
        if($obj instanceof Boolean){
            return $this->value === $obj->booleanValue();
        }
        return false;
    }


    /**
     * Compares this <tt>Boolean</tt> instance with another.
     *
     * @param   b the <tt>Boolean</tt> instance to be compared
     * @return  zero if this object represents the same boolean value as the
     *          argument; a positive value if this object represents true
     *          and the argument represents false; and a negative value if
     *          this object represents false and the argument represents true
     * @throws  NullPointerException if the argument is <tt>null</tt>
     * @see     Comparable
     * @since  1.5
     */
    public function compareTo(Object $obj) {
        if($obj === null)
            throw new NullPointerException();
        if($obj instanceof Boolean)
            return $this->value == $obj->value ? 0 : ($this->value ? 1 : -1);
        throw new ClassCastException('Could not cast '.$obj->getClass()->getName().' to Boolean.');
    }

    public static function compare(Object $obj1, Object $obj2) {
        if($obj1 === null || $obj2 === null)
            throw new NullPointerException();
        if($obj1 instanceof Boolean && $obj2 instanceof Boolean)
            return $obj1->value == $obj2->value ? 0 : ($obj1->value ? 1 : -1);
        throw new ClassCastException('Could not cast '.$obj1->getClass()->getName().' to Boolean.');
    }

    /**
     *
     * @param string|blaze\lang\String $value
     */
    public static function toBoolean($value){
        if($value instanceof String)
            return (($value != null) && $value->equalsIgnoreCase("true"));
        else
            return (($value != null) && $value === "true");
    }


    /**
     *
     * @param blaze\lang\Boolean|boolean $value
     * @return boolean
     */
    public static function asNative($value){
        if($value instanceof Boolean)
            return $value->value;
        else if(is_bool($value))
            return $value;
        else
            return (boolean)String::asNative($value);
    }

    /**
     *
     * @param blaze\lang\Boolean|boolean $value
     * @return blaze\lang\Boolean
     */
    public static function asWrapper($value){
        if($value instanceof Boolean)
            return $value;
        else
            return new self($value);
    }

}
?>
