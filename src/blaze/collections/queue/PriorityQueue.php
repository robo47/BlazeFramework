<?php

namespace blaze\collections\queue;

use blaze\lang\Object;

/**
 * A priority based queue is like a sorted queue. The elements must implement
 * either comparable or a comparator has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Implementation and documentation.
 */
class PriorityQueue extends AbstractQueue implements \blaze\io\Serializable {

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add(\blaze\lang\Reflectable $obj) {
        
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        
    }

    /**
     * Removes all elements from this collections
     */
    public function clear() {

    }

    public function isEmpty() {

    }

    public function getIterator() {

    }

    public function count() {
        
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

    /**
     * @return blaze\lang\Comparator
     */
    public function comparator() {
        
    }

    public function element() {
        
    }

    public function offer(\blaze\lang\Reflectable $element) {
        
    }

    public function peek() {
        
    }

    public function poll() {
        
    }

    public function removeElement() {
        
    }

}

?>
