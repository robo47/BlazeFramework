<?php

namespace blaze\collections\arrays;

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
abstract class AbstractArray extends Object implements \blaze\collections\ArrayI {

    /**
     *
     * @var array
     */
    protected $objects;
    /**
     *
     * @var int
     */
    protected $size;

    /**
     *
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
     *
     * @access private
     */
    public function __get($name) {
        if ($name == 'length')
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
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        // Not needed?
        //return array_key_exists($offset, $this->objects);
    }

    /**
     *
     * @access private
     */
    public function offsetGet($offset) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if ($offset < 0 || $offset > $this->size)
            throw new \blaze\lang\IndexOutOfBoundsException($offset);
        return $this->objects[$offset];
    }

    /**
     *
     * @access private
     */
    public function offsetSet($offset, $value) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if ($offset < 0 || $offset > $this->size)
            throw new \blaze\lang\IndexOutOfBoundsException($offset);
        if ($this->isTyped())
            $this->checkType($value);
        $this->objects[$offset] = $value;
    }

    /**
     *
     * @access private
     */
    public function offsetUnset($offset) {
        if (!\blaze\lang\Integer::isNativeType($offset))
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

    public function hashCode() {
        return \blaze\collections\Arrays::flatHashCode($this);
    }

    public function equals(\blaze\lang\Reflectable $o) {
        return \blaze\collections\Arrays::flatEquals($this, $o);
    }

    public function toString() {
        return \blaze\collections\Arrays::flatToString($this);
    }

}

?>