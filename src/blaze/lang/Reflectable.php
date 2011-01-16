<?php

namespace blaze\lang;

/**
 * Description of Reflectable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @method  blaze\lang\ClassWrapper classWrapper Returns the ClassWrapper object for the class
 */
interface Reflectable {

    /**
     * Creates and returns a copy of this object.
     * @access protected
     * @throws 	blaze\lang\CloneNotSupportedException If the class does not implement the Cloneable interface.
     *                                                Subclasses can override the clone method and throw this exception.
     * @return 	blaze\lang\Reflectable Returns the cloned object.
     */
    public function cloneObject();

    /**
     * Called by the garbage collector on an object when garbage collections determines that there are no more references to the object.
     * @access protected
     */
    public function finalize();

    /**
     * Identifies if the given object is equal to this one.
     *
     * @param 	blaze\lang\Reflectable $obj The reference object with which to compare.
     * @return 	boolean True if the object is the same as the parameter, otherwise false.
     */
    public function equals(Reflectable $obj);

    /**
     * Returns the runtime class of the object.
     *
     * @return 	blaze\lang\ClassWrapper Returns a ClassWrapper which represents the class of the object.
     */
    public function getClass();

    /**
     * Returns a hash code for the object. This method is used by blaze\util\Hashtable.
     *
     * @return 	int A hash code value for this object.
     */
    public function hashCode();

    /**
     * Returns a string representation of the Object which includes the hash code of the object.
     *
     * @return 	blaze\lang\String A string representation of the object.
     */
    public function toString();
}

?>
