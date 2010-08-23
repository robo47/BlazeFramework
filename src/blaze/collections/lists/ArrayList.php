<?php

namespace blaze\collections\lists;

use blaze\lang\Object;

/**
 * Description of ArrayList
 *
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ArrayList extends AbstractList implements \blaze\lang\Cloneable, \blaze\io\Serializable {

    private $elementData;
    private $size;

    public function __construct(\blaze\collections\Collection $collection = null) {
        if ($collection != null) {
            $this->elementData = $collection->toArray();
            $this->size = count($this->elementData);
        } else {
            $this->size = 0;
            $this->elementData = array();
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj) {
        $this->elementData[$this->size++] = $obj;
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        $this->rangeCheck($index);
        $ar = $c->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            $this->add($ar[$i]);
        }
    }

    public function addAllAt($index, \blaze\collections\Collection $c) {
        $this->rangeCheck($index);
        $ar = $c->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            $this->addAt(($index) + $i, $ar[$i]);
        }
    }

    public function addAt($index, $obj) {
        $this->rangeCheck($index);
        array_splice($this->elementData, $index, count($this->elementData), array_merge(array($obj), array_slice($this->elementData, $index)));
        $this->size++;
        return true;
    }

    /**
     * Removes all elements from this collections
     */
    public function clear() {
        $this->elementData = array();
        $this->size = 0;
    }

    public function isEmpty() {
        return $this->size == 0;
    }

    public function getIterator() {
        return new ArrayListIterator($this->elementData);
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj) {
        if ($this->indexOf($obj) == -1)
            return false;
        else
            return true;
    }

    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c) {
        $ar = $c->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            if ($this->indexOf($ar[$i]) == -1) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj) {
        $index = $this->indexOf($obj);
        if ($index == -1) {
            return false;
        } else {
            for ($index; $index < $this->size; $index++) {
                $this->elementData[$index] = $this->elementData[($index + 1)];
            }
            unset($this->elementData[$index - 1]);
            $this->size--;
            return true;
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        $save = $this->elementData;
        $ar = $obj->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            if (!$this->remove($ar[$i])) {
                $this->elementData = $save;
                return false;
            }
        }

        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        if (!$this->containsAll($obj)) {
            return false;
        }
        $diff = array_diff($this->elementData, $obj->toArray());
        $old = $this->elementData;
        $oldsize = $this->size;
        do {
            if (false == $this->remove(current($diff))) {
                $this->elementData = $old;
                $this->size = $oldsize;
                return false;
            }
        } while (next(&$diff));

        return true;
    }

    /**
     * @return blaze\collections\ArrayObject
     */
    public function toArray($type = null) {
        return $this->elementData;
    }

    public function get($index) {
        $this->rangeCheck($index);
        return $this->elementData[$index];
    }

    public function indexOf($obj) {
        $index = array_search($obj, $this->elementData, true);
        if (\is_int($index)) {
            return $index;
        } else {
            return -1;
        }
    }

    public function lastIndexOf($obj) {
        for ($i = $this->size - 1; $i >= 0; $i--)
            if ($obj === $this->elementData[$i])
                return $i;
    }

    public function listIterator($index = 0) {
        
    }

    public function removeAt($index) {
        $this->rangeCheck($index);
        for ($i = $index; $i < $this->size; $i++) {
            $this->elementData[$i] = $this->elementData[($i + 1)];
        }
        unset($this->elementData[$i]);
        $this->size--;
    }

    public function set($index, $obj) {
        $this->rangeCheck($index);
        $old = $this->elementData[$index];
        $this->elementData[$index] = $obj;
        return $old;
    }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {
        if (!$fromInclusive) {
            $fromIndex++;
        }
        if ($toInclusive) {
            $toIndex++;
        }
        $this->rangeCheck($fromIndex);
        $this->rangeCheck($toIndex);
        $ret = new ArrayList();
        for ($i = $fromIndex; $i < $toIndex; $i++) {
            $ret->add($this->elementData[$i]);
        }
        return $ret;
    }

    private function rangeCheck($index) {
        if ($index < 0 || $this->size < $index) {
            throw new \blaze\lang\IndexOutOfBoundsException('Index: ' . $index . ' Size: ' . $this->size);
        }
    }

}

class ArrayListIterator implements \blaze\collections\Iterator {

    private $data;

    public function __construct(&$data) {
        $this->data = $data;
    }

    public function current() {
        return current($this->data);
    }

    public function hasNext() {
        if (next($this->data)) {
            prev($this->data);
            return true;
        } else {
            return false;
        }
    }

    public function key() {
        return key($this->data);
    }

    public function next() {
        return next($this->data);
    }

    public function remove() {
        unset($this->data[$this->key()]);
    }

    public function rewind() {
        reset($this->data);
    }

    public function valid() {
        return (current($this->data) !== false);
    }

}

?>
