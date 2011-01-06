<?php
namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * Basic implementation of an ArrayI.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
abstract class AbstractArray extends Object implements \blaze\collections\ArrayI {

    /**
     * The native array which is used by this wrapper.
     * @var array
     */
    protected $objects;
    /**
     * The size of the array.
     * @var int
     */
    protected $size;

    /**
     * Creates a new ArrayI which uses the parameter as array or size for the Array.
     * @param array|int|blaze\collections\ArrayI $arrayOrSize
     */
    public function __construct($arrayOrSize) {
        if (is_array($arrayOrSize)) {
            $this->objects = $arrayOrSize;
            $this->size = count($arrayOrSize);
        } else if ($arrayOrSize instanceof AbstractArray) {
            $this->objects = $arrayOrSize->objects;
            $this->size = $arrayOrSize->size;
        } else if ($arrayOrSize instanceof \blaze\collections\ArrayI) {
            foreach($arrayOrSize as $obj)
                $this->objects[] = $obj;
            $this->size = count($this->objects);
        } else {
            $this->objects = array();
            $this->size = \blaze\lang\Integer::asNative($arrayOrSize);
        }
    }

    /**
     * This method is for offering the length attribute.
     * @access private
     * @return int
     */
    public function __get($name) {
        if ($name == 'length')
            return $this->count();
        return null;
    }

    /**
     * Returns the size of the array
     * @return int
     */
    public function count() {
        return $this->size;
    }

    /**
     * Alias for count.
     * @return int
     */
    public function size(){
        return $this->count();
    }

    /**
     * Checks wether the offset exists or not.
     * @return boolean
     * @throws \blaze\lang\IllegalArgumentException If the offset is not a number.
     */
    public function offsetExists($offset) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        // Not needed?
        //return array_key_exists($offset, $this->objects);
    }

    /**
     * Returns the object which is stored at the offset in the array.
     * @return mixed|\blaze\lang\Reflectable
     * @throws \blaze\lang\IllegalArgumentException If the offset is not a number.
     * @throws \blaze\lang\IndexOutOfBoundsException If the offset is not within the range of the array.
     */
    public function offsetGet($offset) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if ($offset < 0 || $offset > $this->size)
            throw new \blaze\lang\IndexOutOfBoundsException($offset);
        return $this->objects[$offset];
    }

    /**
     * Sets value at the offset in the array.
     * @throws \blaze\lang\IllegalArgumentException If the offset is not a number.
     * @throws \blaze\lang\IndexOutOfBoundsException If the offset is not within the range of the array.
     */
    public function offsetSet($offset, $value) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if ($offset < 0 || $offset > $this->size)
            throw new \blaze\lang\IndexOutOfBoundsException($offset);
        $this->objects[$offset] = $value;
    }

    /**
     * Unsets the object at the offset in the array.
     * @throws \blaze\lang\IllegalArgumentException If the offset is not a number.
     */
    public function offsetUnset($offset) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        // Not needed?
    }

    /**
     * Returns a new iterator object to traverse through the array.
     * @access private
     * @return \blaze\collections\Iterator
     */
    public function getIterator() {
        return; // new Iterator();
    }

    /**
     * {@inheritDoc}
     * @return int
     */
    public function hashCode() {
        return \blaze\collections\Arrays::flatHashCode($this);
    }

    /**
     * {@inheritDoc}
     * @param \blaze\lang\Reflectable $o
     * @return boolean
     */
    public function equals(\blaze\lang\Reflectable $o) {
        return \blaze\collections\Arrays::flatEquals($this, $o);
    }

    /**
     * {@inheritDoc}
     * @return \blaze\lang\String
     */
    public function toString() {
        return \blaze\collections\Arrays::flatToString($this);
    }

}

?>