<?php
namespace blaze\collections\map;

/**
 * A sorted map is nearly like a normal map, with the difference that the elements
 * are ordered in a sorted way in the map. Because of this, the
 * comparable interface must be implemented by their elements or a comparator
 * has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SortedMap extends \blaze\collections\Map, \blaze\collections\Sorted{

    /**
     * Returns the first (lowest) key currently in this map.
     * @return mixed
     */
    public function firstKey();
    /**
     * Returns the last (highest) key currently in this map.
     * @return mixed
     */
    public function lastKey();

    /**
     * Returns the least key greater than or equal to the given key, or null if there is no such key.
     * @return mixed
     */
    public function ceilingKey($key);
    /**
     * Returns the greatest key less than or equal to the given key, or null if there is no such key.
     * @return mixed
     */
    public function floorKey($key);

    /**
     * Returns the least key strictly greater than the given key, or null if there is no such key.
     * @return mixed
     */
    public function higherKey($key);

    /**
     * Returns the greatest key strictly less than the given key, or null if there is no such key.
     * @return mixed
     */
    public function lowerKey($key);

    /**
     * Returns a reverse order SortedSet view of the keys contained in this map.
     * @return blaze\collections\SortedSet
     */
    public function descendingKeySet();

    /**
     * Returns a reverse order view of the mappings contained in this map.
     * @return blaze\collections\SortedMap
     */
    public function descendingMap();

    /**
     * Returns a key-value mapping associated with the least key in this map, or null if the map is empty.
     * @return blaze\collections\MapEntry
     */
    public function firstEntry();

    /**
     * Returns a key-value mapping associated with the greatest key in this map, or null if the map is empty.
     * @return blaze\collections\MapEntry
     */
    public function lastEntry();

    /**
     * Retrieves and removes the first (lowest) entry, or returns null if this map is empty.
     * @return blaze\collections\MapEntry
     */
    public function pollFirstEntry();

    /**
     * Retrieves and removes the last (highest) entry, or returns null if this map is empty.
     * @return blaze\collections\MapEntry
     */
    public function pollLastEntry();

    /**
     *  Returns a key-value mapping associated with the least key greater than or equal to the given key, or null if there is no such key.
     * @return blaze\collections\MapEntry
     */
    public function ceilingEntry($key);

    /**
     *  Returns a key-value mapping associated with the greatest key less than or equal to the given key, or null if there is no such key.
     * @return blaze\collections\MapEntry
     */
    public function floorEntry($key);

    /**
     * Returns the least key strictly greater than the given key, or null if there is no such key.
     * @return blaze\collections\MapEntry
     */
    public function higherEntry($key);

    /**
     * Returns the greatest key strictly less than the given key, or null if there is no such key.
     * @return blaze\collections\MapEntry
     */
    public function lowerEntry($key);
    /**
     * Returns a view of the current map which starts at the first element of the map
     * and ends at the element toElement.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $inclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedMap
     */
    public function headMap($toElement, $inclusive = true);

    /**
     * Returns a view of the current map which starts at the fromElement and ends
     * at toElement of the map.
     * @param mixed $fromElement The element which is the mark at which to start the view.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $fromInclusive Specifies wether the element fromElement is included in the view or not.
     * @param boolean $toInclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedMap
     */
    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * Returns a view of the current map which starts at the fromElement and ends
     * at the end of the map.
     * @param mixed $fromElement The element which is the indicator at where to start the view.
     * @param boolean $inclusive Specifies wether the element fromElement is included in the view or not.
     * @return blaze\collections\SortedMap
     */
    public function tailMap($fromElement, $inclusive = true);

}

?>
