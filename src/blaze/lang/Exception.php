<?php
namespace blaze\lang;
/**
 * Description of Exception
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Write a test and documentation.
 */

class Exception extends \Exception implements Reflectable {

    /**
     *
     * @param blaze\lang\String|string $message
     * @param blaze\lang\Integer|int $code
     * @param blaze\lang\Exception $previous
     */
    public function __construct ($message = null, $code = null, $previous = null) {
        parent::__construct(String::asNative($message),
                            Integer::asNative($code),
                            $previous);

        if($previous != null && !$previous instanceof Exception)
            new IllegalArgumentException('Previous Exception must be a subclass of Exception',0,$this);
    }

    /**
     * @access protected
     */
    public function cloneObject(){
        if(!$this instanceof Cloneable)
                throw new CloneNotSupportedException();
        return clone $this;
    }

    /**
     * @access protected
     */
    public function finalize(){}

    /**
     * Magic method of PHP, look at the finalize Method for details.
     * @access private
     */
    public final function __destruct() {
        $this->finalize();
    }

    /**
     *
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
     * Returns a hash code for the object. This method is used by blaze\util\Hashtable.
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
        return $this->getTraceAsString();
    }

    /**
     * @access private
     * @return string
     */
//    public final function  __toString() {
//        return String::asNative($this->toString());
//    }
}
?>