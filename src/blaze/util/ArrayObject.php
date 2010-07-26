<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read integer $length
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
class ArrayObject extends Object implements \IteratorAggregate, \Countable, \ArrayAccess {
    /**
     *
     * @var \ArrayObject
     */
    private $objects;

    public function __construct($array = null){
        if($array == null || !is_array($array))
            $this->objects = new \ArrayObject();
        else
            $this->objects = new \ArrayObject($array);
    }
    public function  __get($name) {
        if($name == 'length')
            return $this->count();
        return null;
    }
    public function count() {
        return $this->objects->count();
    }
    public function offsetExists($offset) {
        return $this->objects->offsetExists($offset);
    }
    public function offsetGet($offset) {
        return $this->objects->offsetGet($offset);
    }
    public function offsetSet($offset, $value) {
        $this->objects->offsetSet($offset, $value);
    }
    public function offsetUnset($offset) {
        $this->objects->offsetUnset($offset);
    }
    public function getIterator() {
        return $this->objects->getIterator();
    }
}
?>