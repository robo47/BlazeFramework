<?php
namespace blaze\lang;

/**
 * The class Object is the root of the BlazeFramework
 * which has to be the superclass of every other class.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since	1.0
 * @author 	Christian Beikov
 */
class Object implements Reflectable{
    
    /**
     * {@inheritDoc}
     * @access protected
     */
    public function cloneObject(){
        if(!$this instanceof Cloneable)
                throw new CloneNotSupportedException();
        return clone $this;
    }

    /**
     * {@inheritDoc}
     * @access protected
     */
    public function finalize(){}

    /**
     * Magic method of PHP, look at the cloneObject Method for details.
     * @access private
     */
    public final function __clone() {
        $this->cloneObject();
    }

    /**
     * Magic method of PHP, look at the finalize Method for details.
     * @access private
     */
    public final function __destruct() {
        $this->finalize();
    }

    /**
     * For easy getting a ClassWrapper object like:
     *
     * $class = Object::classWrapper();
     * @access private
     */
    public static final function __callStatic($name, $args) {
        if($name === 'classWrapper')
            return ClassWrapper::forName(get_called_class());
        return null;
    }

    /**
     * Identifies if the given object is equal to this one.
     *
     * @param 	blaze\lang\Reflectable $obj The reference object with which to compare.
     * @return 	boolean True if the object is the same as the parameter, otherwise false.
     */
    public function equals(Reflectable $obj){
        return $this == $obj;
    }

    /**
     * Returns the runtime class of the object.
     * 
     * @return 	blaze\lang\ClassWrapper Returns a ClassWrapper which represents the class of the object.
     */
    public function getClass(){
        return ClassWrapper::forName(get_class($this));
    }
    /**
     * Returns a hash code for the object. This method is used by classes which try to raise the performance of hashcodes.
     *
     * @return 	int A hash code value for this object.
     */
    public function hashCode(){
        return spl_object_hash($this);
    }
     /**
     * Returns a string representation of the Object which includes the hash code of the object.
      *
     * @return 	blaze\lang\String A string representation of the object.
     */
    public function toString() {
        return $this->getClass()->getName() . "@" . dechex(($this->hashCode()));
    }

    /**
     * @access private
     * @return string
     */
    public final function  __toString() {
        return String::asNative($this->toString());
    }
}
?>
