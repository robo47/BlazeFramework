<?php

namespace blaze\collections\bidimap;

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
final class BoundedSortedBidiMap implements \blaze\collections\bidimap\SortedBidiMap, \blaze\collections\Bounded {

    private $bidiMap;
    private $maxCount;

    public function __construct(\blaze\collections\bidimap\SortedBidiMap $bidiMap, $maxCount) {
        $this->bidiMap = $bidiMap;
        $this->maxCount = $maxCount;
    }

    public function isFull() {

    }

    public function maxCount() {

    }

    
public function getKey($value) {

    }
public function removeValue($value) {

    }
    public function clear(){}
    public function containsKey($key){}
    public function containsValue($value){}
    public function entrySet(){}
    public function keySet(){}
    public function valueSet(){}
    public function get($key){}
    public function put($key, $value){}
    public function putAll(\blaze\collections\Map $m){}
    public function remove($key){}
    public function values(){}
    public function isEmpty(){}
    public function count(){}
    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator(){}


    public function ceiling($element) {

    }

    public function ceilingEntry($key) {

    }

    public function ceilingKey($key) {

    }

    public function comparator() {

    }


    public function descendingIterator() {

    }

    public function descendingKeySet() {

    }

    public function descendingMap() {

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

    public function headMap($toElement, $inclusive = true) {

    }

    public function higher($element) {

    }

    public function higherEntry($key) {

    }

    public function higherKey($key) {

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

    public function pollFirst() {

    }

    public function pollFirstEntry() {

    }

    public function pollLast() {

    }

    public function pollLastEntry() {

    }
    public function containsAll(Map $c) {

    }
    public function removeAll(Map $obj) {

    }

    public function retainAll(Map $obj) {

    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function tailMap($fromElement, $inclusive = true) {

    }

}

?>
