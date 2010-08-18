<?php
namespace blaze\collections;
use blaze\lang\Object;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read int $length
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
class ArrayObject extends Object implements Iterable, Countable, ArrayAccess, Immutable {

    private static $basicTypes = array( 'string', 'array', 'resource',
                                        'float', 'double', 'real',
                                        'int', 'integer', 'long',
                                        'bool', 'boolean');

    private $class = null;
    private $type = null;
    private $typeName = null;

    /**
     *
     * @var array
     */
    private $objects;
    /**
     *
     * @var int
     */
    private $size;

    /**
     *
     * @param array|int $arrayOrSize
     */
    public function __construct($arrayOrSize = null, $type = null){
        if($type !== null){
            if(in_array($type, self::$basicTypes)){
                $this->type = $type;
                $this->typeName = new \blaze\lang\String($type);
            }else if($type instanceof \blaze\lang\ClassWrapper){
                $this->class = $type;
                $this->typeName = $type->getName();
            }else{
                $this->class = \blaze\lang\ClassWrapper::forName(\blaze\lang\String::asNative($type));
                $this->typeName = $this->class->getName();
            }
        }
        if(is_array($arrayOrSize) || $arrayOrSize instanceof ArrayObject){
            if($this->isTyped()){
                foreach($arrayOrSize as $value){
                    $this->checkType($value);
                }
            }
            $this->objects = $arrayOrSize;
            $this->size = count($arrayOrSize);
        }else{
            $this->objects = array();
            $this->size = \blaze\lang\Integer::asNative($arrayOrSize);
        }
    }

    public function isTyped(){
        return $this->typeName !== null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getType(){
        return $this->typeName;
    }

    /**
     *
     * @return boolean
     */
    public function isNative(){
        return $this->class == null;
    }

    /**
     *
     * @access private
     */
    public function  __get($name) {
        if($name == 'length')
            return $this->count();
        return null;
    }
    /**
     *
     * @access private
     */
    public function count() {
        return $this->size;
    }
    /**
     *
     * @access private
     */
    public function offsetExists($offset) {
        if(!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        // Not needed?
        //return array_key_exists($offset, $this->objects);
    }
    /**
     *
     * @access private
     */
    public function offsetGet($offset) {
        if(!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if($offset < 0 || $offset > $this->size)
                throw new \blaze\lang\IndexOutOfBoundsException($offset);
        return $this->objects[$offset];
    }
    /**
     *
     * @access private
     */
    public function offsetSet($offset, $value) {
        if(!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if($offset < 0 || $offset > $this->size)
                throw new \blaze\lang\IndexOutOfBoundsException($offset);
        if($this->isTyped())
                $this->checkType($value);
       $this->objects[$offset] = $value;
    }
    /**
     *
     * @access private
     */
    public function offsetUnset($offset) {
        if(!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        // Not needed?
    }
    /**
     *
     * @access private
     */
    public function getIterator() {
        return; // new Iterator();
    }

    private function checkType($value){
        if($this->type != null){
            switch(strtolower($type)){
                case 'string':
                    if (!is_string($value))
                        $this->throwException($value);
                    break;
                case 'array':
                    if (!is_array($value))
                        $this->throwException($value);
                    break;
                case 'resource':
                    if (!is_resource($value))
                        $this->throwException($value);
                    break;
                case 'float':
                case 'double':
                case 'real':
                    if (!is_float($value))
                        $this->throwException($value);
                    break;
                case 'int':
                case 'int':
                case 'long':
                    if (!is_int($value))
                        $this->throwException($value);
                    break;
                case 'bool':
                case 'boolean':
                    if (!is_bool($value))
                        $this->throwException($value);
                    break;
            }
        }else{
            if(!$this->class->isInstance($value))
                    $this->throwException($value);
        }
    }

    private function throwException($value){
        throw new \blaze\lang\IllegalArgumentException($value.' must be of the type '.$this->typeName);
    }

    public function hashCode(){
        return Arrays::flatHashCode($this);
    }

    public function equals(Object $o){
        return Arrays::flatEquals($this, $o);
    }

    public function toString(){
        return Arrays::flatToString($this);
    }
}
?>