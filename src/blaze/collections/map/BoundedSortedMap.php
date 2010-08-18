<?php

namespace blaze\collections\map;

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
final class BoundedSortedMap implements \blaze\collections\map\SortedMap, \blaze\collections\Bounded {

    private $map;
    private $maxCount;

    public function __construct(\blaze\collections\map\SortedMap $map, $maxCount) {
        $this->map = $map;
        $this->maxCount = $maxCount;
    }

    public function ceiling($element) {

    }

    public function ceilingEntry($key) {

    }

    public function ceilingKey($key) {

    }

    public function clear() {

    }

    public function comparator() {

    }

    public function containsAll(Map $c) {

    }

    public function containsKey($key) {

    }

    public function containsValue($value) {

    }

    public function count() {

    }

    public function descendingIterator() {

    }

    public function descendingKeySet() {

    }

    public function descendingMap() {

    }

    public function entrySet() {

    }

    public function first() {

    }

    public function firstEntry() {

    }

    public function firstKey() {

    }

    public function floor($element) {

    }

    public function floorEntry($key) {

    }

    public function floorKey($key) {

    }

    public function get($key) {

    }

    public function headMap($toElement, $inclusive = true) {

    }

    public function higher($element) {

    }

    public function higherEntry($key) {

    }

    public function higherKey($key) {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function keySet() {

    }

    public function last() {

    }

    public function lastEntry() {

    }

    public function lastKey() {

    }

    public function lower($element) {

    }

    public function lowerEntry($key) {

    }

    public function lowerKey($key) {

    }

    public function maxCount() {

    }

    public function pollFirst() {

    }

    public function pollFirstEntry() {

    }

    public function pollLast() {

    }

    public function pollLastEntry() {

    }

    public function put($key, $value) {

    }

    public function putAll(Map $m) {

    }

    public function remove($key) {

    }

    public function removeAll(Map $obj) {

    }

    public function retainAll(Map $obj) {

    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function tailMap($fromElement, $inclusive = true) {

    }

    public function values() {

    }

}

?>
