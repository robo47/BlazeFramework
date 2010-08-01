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
     * @param blaze\lang\Integer|integer $code
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
     *
     * @return blaze\lang\Object
     */
    public function cloneObject(){
        return clone $this;
    }
    /**
     * @param blaze\lang\Object $obj The reference object with which to compare.
     * @return boolean
     */
    public function equals(Reflectable $obj){
        return $this === $obj;
    }

    public function  __destruct() {}
    /**
     *
     * @return blaze\lang\ClassWrapper
     */
    public function getClass(){
        return ClassWrapper::forName(new String((get_class($this))));
    }
    /**
     *
     * @return blaze\lang\String
     */
    public function hashCode(){
        return spl_object_hash($this);
    }
}
?>