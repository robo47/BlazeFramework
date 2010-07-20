<?php
namespace blaze\lang;

/**
 * The class Object is the root of the BlazeFramework
 * which has to be the superclass of every other class.
 *
 * @license	http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link	http://blazeframework.sourceforge.net
 * @since	1.0
 * @version $Revision$
 * @see 	blaze\lang\ClassWrapper
 * @author 	Christian Beikov
 */
class Object {
    /**
     * Creates and returns a copy of this object.
     *
     * @throws 	blaze\lang\CloneNotSupportedException If the class does not implement the Cloneable interface.
     *                                                Subclasses can override the clone method and throw this exception.
     * @return 	blaze\lang\Object Returns the cloned object.
     */
    public function cloneObject(){
        if(!$this instanceof Cloneable)
                throw new CloneNotSupportedException();
        return clone $this;
    }
    /**
     * Magic method of PHP, look at the cloneObject Method for details.
     */
    public function __clone() {
        $this->cloneObject();
    }
    /**
     * Identifies if the given object is equal to this one.
     *
     * @param 	blaze\lang\Object $obj The reference object with which to compare.
     * @return 	blaze\lang\Boolean True if the object is the same as the parameter, otherwise false.
     */
    public function equals(Object $obj){
        return $this == $obj;
    }

    /**
     * Returns the runtime class of the object.
     * 
     * @return 	blaze\lang\ClassWrapper Returns a ClassWrapper which represents the class of the object.
     */
    public function getClass(){
        return ClassWrapper::forName(new String((get_class($this))));
    }
    /**
     * Returns a hash code for the object. This method is used by blaze\util\Hashtable.
     *
     * @return 	blaze\lang\String A hash code value for this object.
     */
    public function hashCode(){
        return spl_object_hash($this);
    }
     /**
     * Returns a string representation of the Object which includes the hash code of the object.
      *
     * @return 	blaze\lang\String A string representation of the object.
     */
    public function  __toString() {
        return new String($this->getClass()->getName() . "@" . dechex(($this->hashCode())));
    }
}
?>
