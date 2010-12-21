<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * This class can be used as base class if only specific methods need a different
 * behaviour and the main behaviour is given by an ArrayI object. Every method
 * passes on the parameters to the methods of the object and return their values.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
abstract class AbstractArrayDecorator extends Object implements \blaze\collections\ArrayI {

    /**
     *
     * @var array
     */
    protected $array;

    /**
     *
     * @param \blaze\collections\ArrayI  $array
     */
    public function __construct(\blaze\collections\ArrayI $array) {
        $this->array = $array;
    }

    /**
     *
     * @access private
     */
    public function __get($name) {
        return $this->array->__get($name);
    }

    /**
     *
     * @access private
     */
    public function count() {
        return $this->array->count();
    }

    /**
     *
     * @access private
     */
    public function offsetExists($offset) {
        return $this->array->offsetExists($offset);
    }

    /**
     *
     * @access private
     */
    public function offsetGet($offset) {
        return $this->array->offsetGet($offset);
    }

    /**
     *
     * @access private
     */
    public function offsetSet($offset, $value) {
        return $this->array->offsetSet($offset, $value);
    }

    /**
     *
     * @access private
     */
    public function offsetUnset($offset) {
        return $this->array->offsetUnset($offset);
    }

    /**
     *
     * @access private
     */
    public function getIterator() {
        return $this->array->getIterator();
    }

    public function hashCode() {
        return $this->array->hashCode();
    }

    public function equals(\blaze\lang\Reflectable $o) {
        return $this->array->equals($o);
    }

    public function toString() {
        return $this->array->toString();
    }

}

?>