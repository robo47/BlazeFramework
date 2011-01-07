<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * This class can be used as base class if only specific methods need a different
 * behaviour and the main behaviour is given by an ArrayI object. Every method
 * passes on the parameters to the methods of the object and return their values.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
abstract class AbstractArrayDecorator extends Object implements \blaze\collections\ArrayI {

    /**
     * The decorated array.
     * @var \blaze\collections\ArrayI
     */
    protected $array;

    /**
     * This constructor should be used by implementations to initialize the array.
     * @param \blaze\collections\ArrayI  $array
     */
    public function __construct(\blaze\collections\ArrayI $array) {
        $this->array = $array;
    }

    /**
     * @access private
     */
    public function __get($name) {
        return $this->array->__get($name);
    }

    /**
     * Returns the size of the decorated array.
     * @return int
     */
    public function count() {
        return $this->array->count();
    }

    /**
     * Returns the size of the decorated array.
     * @return int
     */
    public function size() {
        return $this->count();
    }

    /**
     * Return wether the offset exists in the decorated array or not
     * @param int $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return $this->array->offsetExists($offset);
    }

    /**
     * Returns the object on the offset in the decorated array.
     * @param int $offset
     * @return mixed|\blaze\lang\Reflectable
     */
    public function offsetGet($offset) {
        return $this->array->offsetGet($offset);
    }

    /**
     * Sets the object on the offset in the decorated array.
     * @param int $offset
     * @param mixed|\blaze\lang\Reflectable $value
     */
    public function offsetSet($offset, $value) {
        return $this->array->offsetSet($offset, $value);
    }

    /**
     * Unsets the object on the offset in the decorated array.
     * @param int $offset
     */
    public function offsetUnset($offset) {
        return $this->array->offsetUnset($offset);
    }

    /**
     * Returns an iterator to iterate over the decorated array.
     * @return \blaze\collections\Iterator
     */
    public function getIterator() {
        return $this->array->getIterator();
    }

    /**
     * {@inheritDoc}
     * @return int
     */
    public function hashCode() {
        return $this->array->hashCode();
    }

    /**
     * {@inheritDoc}
     * @param \blaze\lang\Reflectable $o
     * @return boolean
     */
    public function equals(\blaze\lang\Reflectable $o) {
        return $this->array->equals($o);
    }

    /**
     * {@inheritDoc}
     * @return \blaze\lang\String
     */
    public function toString() {
        return $this->array->toString();
    }

}

?>