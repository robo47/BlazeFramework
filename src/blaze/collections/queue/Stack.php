<?php

namespace blaze\collections\queue;

use blaze\lang\Object;

/**
 * A stack is an implementation of a queue which follows the last-in-first-out principle.
 * 
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/1.4.2/docs/api/java/util/Stack.html
 * @since   1.0
 * @todo    Tuning, extending the class to be more java like and documentation.
 */
class Stack extends \blaze\collections\queue\AbstractQueue {

    private $data;
    private $size;

    public function __construct() {
        $this->data = array();
        $this->size = 0;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $this->data[$this->size] = $obj;
        $this->size++;
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        $ar = $obj->toArray();
        foreach ($ar as $val) {
            $this->add($val);
        }
        return true;
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
        return new StackIterator($this->data, $this);
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains(\blaze\lang\Reflectable $obj) {
		if($this->size == 0)
			return false;
        foreach($this->data as $val)
			if($val->equals($obj))
				return true;
		return false;
    }

    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c) {
        $ar = $c->toArray();
        foreach ($ar as $val) {
            if (!$this->contains($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAt(\int $index) {
        $this->rangeCheck($index);
        $ret = $this->data[$index];
        unset($this->data[$index]);
        $this->data = \array_values($this->data);
        $this->size--;
        return $ret;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        $index = $this->indexOf($obj);
        if ($index === -1) {
            return false;
        } else {
            $this->removeAt($index);
            return true;
        }
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        $ret = true;
        $ar = $obj->toArray();
        foreach ($ar as $val) {
            if (!$this->remove($val)) {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj) {
		$retained = array();
		$arr = $obj->toArray();
		
		for($i = 0; $i < $this->size; $i++){
			for($j = 0; $j < $obj->size(); $j++){
				if($this->data[$i]->equals($arr[$j])){
					$retained[] = $this->data[$i];
					break;
				}
			}
		}
		
		$changed = count($retained) != $this->size;
		$this->size = count($retained);
		$this->data = $retained;
		return $changed;
    }

    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null) {
        return $this->data;
    }

    public function element() {
        return $this->peek();
    }

    public function offer(\blaze\lang\Reflectable $element) {
        return $this->add($element);
    }

    public function peek() {
        if ($this->size == 0) {
            return null;
        }
        return $this->data[($this->size - 1)];
    }

    public function poll() {
        $ret = $this->peek();
        if ($ret != null) {
            $this->removeAt($this->size - 1);
        }
        return $ret;
    }

    public function indexOf(\blaze\lang\Reflectable $obj) {
        foreach($this->data as $key => $element)
			if($obj->equals($element))
				return $key;
		return -1;
    }

    public function removeElement() {
        return $this->poll();
    }

    public function pop() {
        $ret = $this->peek();
        if ($ret != null) {
            $this->removeAt($this->size - 1);
        }
        return $ret;
    }

    public function push(\blaze\lang\Reflectable $element) {
        $this->add($element);
    }

    /**
     *
     * @param <type> $element
     * @return int Returns the 1-based position where an object is on this stack.
     */
    public function search(\blaze\lang\Reflectable $element) {
        return $this->indexOf($element) + 1;
    }

    private function rangeCheck($index) {
        if ($index < 0 || $this->size < $index) {
            throw new \blaze\lang\IndexOutOfBoundsException('Index: ' . $index . ' Size: ' . $this->size);
        }
    }

    public function toString() {
        $ret = 'Stack: ';
        foreach ($this->data as $val) {
            $ret = $ret . $val . '|';
        }
        return $ret;
    }

}

/**
 * @access private
 */
class StackIterator implements \blaze\collections\Iterator {

    private $data;
    private $index;
    /**
     *
     * @var Stack
     */
    private $stack;

    public function __construct(&$data, Stack $stack) {
        $this->data = $data;
        $this->index = (count($this->data) - 1);
        $this->stack = $stack;
    }

    public function current() {
        if (!$this->check($this->index))
            throw new \blaze\lang\IndexOutOfBoundsException($this->index);
        return $this->data[$this->index];
    }

    public function hasNext() {
        return $this->check($this->index - 1);
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index--;
        //return $this->current();
    }

    public function remove() {
        $this->stack->removeAt($this->index);
    }

    public function valid() {
        return $this->check($this->index);
    }

    public function rewind() {
        $this->index = (count($this->data) - 1);
    }

    private function check($index) {
        return array_key_exists($index, $this->data);
    }

}

?>
