<?php
namespace blaze\collections\queue;

/**
 * This is a simple implementation of a deque with an array as internal
 * data store.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Implementation and documentation.
 */
class ArrayDeque extends \blaze\collections\AbstractCollection implements Deque, \blaze\lang\Cloneable, \blaze\io\Serializable{
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj){}
    /**
     * Removes all elements from this collections
     */
    public function clear(){}

    public function isEmpty(){}

    public function getIterator(){}

    public function count(){}
    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj){}
    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj){}
    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null){}

    public function addFirst($element) {

    }

    public function addLast($element) {

    }

    public function descendingIterator() {

    }

    public function element() {

    }

    public function getFirst() {

    }

    public function getLast() {

    }

    public function offer($element) {

    }

    public function peek() {

    }

    public function poll() {

    }

    public function removeElement() {

    }

    public function removeFirst() {

    }

    public function removeFirstOccurrence($element) {

    }

    public function removeLast() {

    }

    public function removeLastOccurrence($element) {

    }
}

?>
