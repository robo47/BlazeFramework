<?php

namespace blaze\collections\set;

use blaze\lang\Object,
 blaze\collections\map\HashMap,
 \blaze\lang\String,
 \blaze\lang\Integer;

/**
 * A simple implementation of a set which uses the hashcodes of objects.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Tuning and documentation
 */
class HashSet extends AbstractSet implements \blaze\lang\Cloneable, \blaze\io\Serializable {

    private $data;
    private $size;
    private $hashs;

    public function __construct(\blaze\collections\Collection $collection =null) {

        $this->data = array();
        $this->size = 0;
        $this->hashs = array();

        if ($collection != null) {
            foreach ($collection as $val) {
                $this->add($val);
            }
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add(\blaze\lang\Reflectable $obj) {
        if ($this->contains($obj)) {
            return false;
        } else {
            $hash = $this->hash($obj);
            $this->data[$hash] = $obj;
            $this->hashs[$this->size] = $hash;
            $this->size++;
            return true;
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        $ar = $obj->toArray();
        $ret = false;
        foreach ($ar as $value) {
            if ($this->add($value)) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * Removes all elements from this collections
     */
    public function clear() {
        $this->data = array();
        $this->size = 0;
    }

    public function isEmpty() {
        return $this->size == 0;
    }

    public function getIterator() {
        return new HashSetIterator($this->data, $this->hashs, $this);
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        $hash = $this->hash($obj);
        return array_key_exists($hash, $this->data);
    }

    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c) {
        $ar = $c->toArray();
        foreach ($ar as $value) {
            if (!$this->contains($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        if ($this->contains($obj)) {
			$hash = $this->hash($obj);
            unset($this->data[$hash]);
            unset($this->hashs[$this->indexOf($hash)]);
            $this->hashs = \array_values($this->hashs);
            $this->size--;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        $ar = $obj->toArray();
        $ret = false;
        foreach ($ar as $value) {
            if ($this->remove($value)) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        $ret = false;
        foreach ($this as $val) {
            if (!$obj->contains($val)) {
                $this->remove($val);
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null) {
        $i = 0;
        $ar = array();
        foreach ($this->data as $val) {
            $ar[$i] = $val;
            $i++;
        }
        return $ar;
    }

    private function hash($key) {
        return String::asNative($key->hashCode());
    }

    private function indexOf($hash) {
        $index = array_search($hash, $this->hashs, true);
        if (\is_int($index)) {
            return $index;
        } else {
            return -1;
        }
    }

}

class HashSetIterator implements \blaze\collections\Iterator {

    /**
     *
     * @var array[blaze\collections\MapEntry]
     */
    private $data;
    private $hashs;
    private $index = 0;
    /**
     *
     * @var HashMap
     */
    private $set;

    public function __construct(&$data, &$hashs, &$set) {
        if (is_array($data)) {
            $this->data = $data;
            $this->hashs = $hashs;
            $this->set = $set;
        } else {
            throw new \blaze\lang\IllegalArgumentException('data must be a Array!');
        }
    }

    public function current() {
        return $this->data[$this->hashs[$this->index]];
    }

    public function hasNext() {
        return $this->check($this->index + 1);
    }

    public function key() {
        return $this->hashs[$this->index];
    }

    public function next() {
        $this->index++;
        if ($this->check($this->index)) {
            return $this->current();
        } else {
            return false;
        }
    }

    public function remove() {
        $this->set->remove($this->current());
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return $this->check($this->index);
    }

    private function check($index) {
        return array_key_exists($index, $this->hashs);
    }

}

?>
