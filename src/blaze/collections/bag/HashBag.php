<?php

namespace blaze\collections\bag;

/**
 * A simple implementation of a bag which uses the hashcodes of objects.
 * Internal it uses a Map with an object as key, and integer as value.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Implement the HashBag with a HashMap as internal store.
 */
class HashBag extends AbstractBag {

    /**
     * Creates a new HashBag with the elements of the given collection.
     */
    public function __construct(\blaze\collections\Collection $col) {

    }

    public function add(\blaze\lang\Reflectable $obj) {

    }

    public function addAll(\blaze\collections\Collection $obj) {

    }

    public function clear() {

    }

    public function isEmpty() {

    }

    public function getIterator() {

    }

    public function count() {

    }

    public function contains(\blaze\lang\Reflectable $obj) {

    }

    public function containsAll(\blaze\collections\Collection $c) {

    }

    public function remove(\blaze\lang\Reflectable $obj) {

    }

    public function removeAll(\blaze\collections\Collection $obj) {

    }

    public function retainAll(\blaze\collections\Collection $obj) {

    }

    public function toArray($type = null) {
        
    }

    public function addCount(\blaze\lang\Reflectable $obj, \int $count) {
        
    }

    public function getCount(\blaze\lang\Reflectable $obj) {
        
    }

    public function removeCount(\blaze\lang\Reflectable $obj, \int $count) {
        
    }

    public function uniqueSet() {
        
    }

}

?>
