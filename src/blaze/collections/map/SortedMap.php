<?php
namespace blaze\collections\map;
use blaze\lang\Object;
/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface SortedMap extends \blaze\collections\Map, \blaze\collections\Sorted{

    /**
     * Returns the first (lowest) key currently in this map.
     */
    public function firstKey();
    /**
     * Returns the last (highest) key currently in this map.
     */
    public function lastKey();

    /**
     * Returns the least key greater than or equal to the given key, or null if there is no such key.
     */
    public function ceilingKey($key);
    /**
     * Returns the greatest key less than or equal to the given key, or null if there is no such key.
     */
    public function floorKey($key);

    /**
     * Returns the least key strictly greater than the given key, or null if there is no such key.
     */
    public function higherKey($key);

    /**
     * Returns the greatest key strictly less than the given key, or null if there is no such key.
     */
    public function lowerKey($key);

    /**
     * Returns a reverse order SortedSet view of the keys contained in this map.
     * @return blaze\collections\SortedSet
     */
    public function descendingKeySet();

    /**
     * Returns a reverse order view of the mappings contained in this map.
     * @return SortedMap
     */
    public function descendingMap();

    /**
     * Returns a key-value mapping associated with the least key in this map, or null if the map is empty.
     */
    public function firstEntry();

    /**
     * Returns a key-value mapping associated with the greatest key in this map, or null if the map is empty.
     */
    public function lastEntry();

    /**
     * Retrieves and removes the first (lowest) entry, or returns null if this map is empty.
     */
    public function pollFirstEntry();

    /**
     * Retrieves and removes the last (highest) entry, or returns null if this map is empty.
     */
    public function pollLastEntry();

    /**
     *  Returns a key-value mapping associated with the least key greater than or equal to the given key, or null if there is no such key.
     */
    public function ceilingEntry($key);

    /**
     *  Returns a key-value mapping associated with the greatest key less than or equal to the given key, or null if there is no such key.
     */
    public function floorEntry($key);

    /**
     * Returns the least key strictly greater than the given key, or null if there is no such key.
     */
    public function higherEntry($key);

    /**
     * Returns the greatest key strictly less than the given key, or null if there is no such key.
     */
    public function lowerEntry($key);
    /**
     * @return blaze\collections\SortedMap
     */
    public function headMap($toElement, $inclusive = true);

    /**
     * @return blaze\collections\SortedMap
     */
    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * @return blaze\collections\SortedMap
     */
    public function tailMap($fromElement, $inclusive = true);

}

?>
