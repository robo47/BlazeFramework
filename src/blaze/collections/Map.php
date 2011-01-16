<?php

namespace blaze\collections;

use blaze\lang\Object;

/**
 * Implementations of this interface provide a key to value mapping in their data
 * storage. Keys can be native types like int, string, float etc. but also complex
 * types(everything below \blaze\lang\Reflectable).
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Map extends Countable, Iterable {

    /**
     * Clears the map, count() has to deliver 0 after this operation.
     * @return void
     */
    public function clear();

    /**
     * Returns wether the key is contained in the map or not.
     * @param \blaze\lang\Reflectable  $key
     * @return boolean true if the key is contained, otherwise false
     */
    public function containsKey(\blaze\lang\Reflectable $key);

    /**
     * Returns wether the value is contained in the map or not.
     * @param \blaze\lang\Reflectable  $value
     * @return boolean true if the value is contained, otherwise false
     */
    public function containsValue(\blaze\lang\Reflectable $value);

    /**
     * Returns a Set of \blaze\collections\MapEntry elements which represent the map.
     * @return \blaze\collections\Set[\blaze\collections\MapEntry]
     */
    public function entrySet();

    /**
     * Returns a Set of the key type elements which represent the keys of the map.
     * @return \blaze\collections\Set[\blaze\lang\Reflectable]
     */
    public function keySet();

    /**
     * Return the value which is mapped to the key
     * @param mixed $key
     * @return \blaze\lang\Reflectable
     */
    public function get(\blaze\lang\Reflectable $key);

    /**
     * Maps the value to the given key
     * @param \blaze\lang\Reflectable  $key
     * @param \blaze\lang\Reflectable  $value
     * @return \blaze\lang\Reflectable  the value
     */
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value);

    /**
     * Merge maps, inserts every entry of the parameter Map into this map.
     * @return void
     */
    public function putAll(Map $m);

    /**
     * Checks if every entry of the parameter Map is contained in this map.
     * @return boolean true if every entry is contained, otherwise false
     */
    public function containsAll(Map $c);

    /**
     * Removes every entry of the parameter Map of this map.
     * @return true on success, otherwise false
     */
    public function removeAll(Map $obj);

    /**
     * Retains every entry of the parameter Map which is also contained in this map.
     * @return true on success, otherwise false
     */
    public function retainAll(Map $obj);

    /**
     * Removes the entry which has the given key.
     * @return mixed the value or null if nothing was removed
     */
    public function remove(\blaze\lang\Reflectable $key);

    /**
     * Returns the values as collection.
     * @return blaze\collections\Collection
     */
    public function values();
}

?>
