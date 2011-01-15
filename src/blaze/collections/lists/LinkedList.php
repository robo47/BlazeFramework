<?php

namespace blaze\collections\lists;

use blaze\lang\Object,
 blaze\collections\ListI;

/**
 * Description of ArrayList
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/1.4.2/docs/api/java/util/LinkedList.html
 * @since   1.0
 * @todo    Tuning and extending the class to be more java like. Documentation.
 */
class LinkedList implements \blaze\collections\Iterable {

    /**
     *
     * @var Entry
     */
    private $head;
    private $size;
    /**
     *
     * @var Entry
     */
    private $tail;

    public function __construct(\blaze\collections\Collection $c=null) {
        if ($c == null) {
            $this->head = new Entry(null, null, null);
            $this->size = 0;
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $new = new Entry($obj);
        if ($this->size == 0) {
            $this->head = $new;
        } else {
            $this->tail->next = $new;
        }
        $new->previous = $this->tail;
        $this->tail = $new;
        $this->size++;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        $ar = $obj->toArray();
        foreach ($ar as $val) {
            $this->add($val);
        }
    }

    /**
     * Removes all elements from this collections
     */
    public function clear() {
        $this->head = null;
        $this->tail = null;
        $this->size = 0;
    }

    public function isEmpty() {
        return $this->size == 0;
    }

    public function getIterator() {
        return new LinkedListIterator($this->head, $this->size);
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        
    }

    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c) {
        
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        $this->clear();
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        
    }

    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null) {

    }

    public function addFirst(\blaze\lang\Reflectable $element) {
        $new = new Entry($element);
    }

    public function addLast(\blaze\lang\Reflectable $element) {
        $this->add($element);
    }

    public function descendingIterator() {

    }

    public function element() {

    }

    public function getFirst() {
        return $this->head->element;
    }

    public function getLast() {
        return $this->tail->element;
    }

    public function offer(\blaze\lang\Reflectable $element) {

    }

    public function offerFirst(\blaze\lang\Reflectable $element) {

    }

    public function offerLast(\blaze\lang\Reflectable $element) {

    }

    public function peek() {

    }

    public function peekFirst() {

    }

    public function peekLast() {

    }

    public function poll() {

    }

    public function pollFirst() {

    }

    public function pollLast() {

    }

    public function pop() {

    }

    public function push(\blaze\lang\Reflectable $element) {

    }

    public function removeElement() {

    }

    public function removeFirst() {

    }

    public function removeFirstOccurrence(\blaze\lang\Reflectable $element) {

    }

    public function removeLast() {

    }

    public function removeLastOccurrence(\blaze\lang\Reflectable $element) {

    }

    /**
     * Inserts all of the elements in the specified collections into this list at the specified position (optional operation).
     * @param int $index
     * @param mixed $element
     */
    public function addAllAt(\int $index, Collection $c) {

    }

    public function addAt(\int $index, \blaze\lang\Reflectable $obj) {

    }

    public function get(\int $index) {

    }

    public function indexOf(\blaze\lang\Reflectable $obj) {

    }

    public function lastIndexOf(\blaze\lang\Reflectable $obj) {

    }

    public function listIterator($index = 0) {

    }

    public function removeAt(\int $index) {

    }

    public function set(\int $index, \blaze\lang\Reflectable $obj) {

    }

    public function subList(\int $fromIndex, \int $toIndex, $fromInclusive = true, $toInclusive = false) {

    }

    public function toString() {
        $akt = $this->head;
        $str = 'LinkedList: ' . $akt->element;
        $akt = $akt->next;
        $i = 0;
        while ($this->size > $i) {
            $str = $str . ' /' . $akt->element;
            $akt = $akt->next;
            $i++;
        }
        return $str;
    }

}

class Entry {

    public $element;
    /**
     *
     * @var Entry
     */
    public $next;
    /**
     *
     * @var Entry
     */
    public $previous;

    public function __construct($element) {
        $this->element = $element;
    }

    public function remove() {
        $this->previous->next = $this->next;
        $this->next->previous = $this->previous;
        unset($this);
    }

}

class LinkedListIterator implements \blaze\collections\Iterator {

    private $head;
    private $size;
    /**
     *
     * @var Entry
     */
    private $cur;
    private $index = 0;
    public function __construct(Entry $head, $size) {
        $this->cur = $head;
        $this->size = $size;
        $this->head = $head;
    }

    public function current() {
        return $this->cur->element;
    }

    public function hasNext() {
        return $this->cur->next != null;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->cur = $this->cur->next;
        $this->index++;
        return $this->cur;
    }

    public function remove() {
        $this->cur->previous->next = $this->cur->next;
        $this->cur->next->previous = $this->cur->previous;
        usnet($this->cur);
        $this->cur = $this->next();
    }

    public function rewind() {
        $this->cur = $head;
    }

    public function valid() {
        return $this->cur != null;
    }

}

?>
