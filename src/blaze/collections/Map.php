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
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface Map extends Countable, Iterable{
    /**
     * Clears the map, count() has to deliver 0 after this operation.
     * @return void
     */
    public function clear();
    /**
     * Returns wether the key is contained in the map or not.
     * @param mixed $key
     * @return boolean true if the key is contained, otherwise false
     */
    public function containsKey($key);
    /**
     * Returns wether the value is contained in the map or not.
     * @param mixed $value
     * @return boolean true if the value is contained, otherwise false
     */
    public function containsValue($value);
    /**
     * Returns a Set of \blaze\collections\MapEntry elements which represent the map.
     * @return \blaze\collections\Set[\blaze\collections\MapEntry]
     */
    public function entrySet();
    /**
     * Returns a Set of the key type elements which represent the keys of the map.
     * @return \blaze\collections\Set[mixed]
     */
    public function keySet();
    /**
     * Return the value which is mapped to the key
     * @param mixed $key
     * @return mixed
     */
    public function get($key);
    /**
     * Maps the value to the given key
     * @param mixed $key
     * @param mixed $value
     * @return mixed the value
     */
    public function put($key, $value);
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
    public function remove($key);
    /**
     * Returns the values as collection.
     * @return blaze\collections\Collection
     */
    public function values();

}

?>
