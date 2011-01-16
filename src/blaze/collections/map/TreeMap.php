<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * This class is an implementation of a SortedMap and keeps the elements ordered
 * in a sorted way. The sortorder is specified through the result of a comparation
 * between two elements with the method Comparable#compareTo() or Comparator#compare()
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Implementation and documentation.
 */
class TreeMap extends AbstractMap implements SortedMap, \blaze\lang\Cloneable, \blaze\io\Serializable {

    public function clear() {

    }

    public function containsKey(\blaze\lang\Reflectable $key) {

    }

    public function containsValue(\blaze\lang\Reflectable $value) {

    }

    public function entrySet() {

    }

    public function keySet() {

    }

    public function valueSet() {

    }

    public function get(\blaze\lang\Reflectable $key) {

    }

    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {

    }

    public function putAll(\blaze\collections\Map $m) {

    }

    public function remove(\blaze\lang\Reflectable $key) {

    }

    public function values() {

    }

    public function isEmpty() {

    }

    public function count() {
        
    }

    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator() {

    }

    public function ceiling(\blaze\lang\Reflectable $element) {

    }

    public function ceilingEntry(\blaze\lang\Reflectable $key) {

    }

    public function ceilingKey(\blaze\lang\Reflectable $key) {

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

    public function floor(\blaze\lang\Reflectable $element) {

    }

    public function floorEntry(\blaze\lang\Reflectable $key) {

    }

    public function floorKey(\blaze\lang\Reflectable $key) {

    }

    public function headMap(\blaze\lang\Reflectable $toElement, $inclusive = true) {

    }

    public function higher(\blaze\lang\Reflectable $element) {

    }

    public function higherEntry(\blaze\lang\Reflectable $key) {

    }

    public function higherKey(\blaze\lang\Reflectable $key) {

    }

    public function last() {

    }

    public function lastEntry() {

    }

    public function lastKey() {

    }

    public function lower(\blaze\lang\Reflectable $element) {

    }

    public function lowerEntry(\blaze\lang\Reflectable $key) {

    }

    public function lowerKey(\blaze\lang\Reflectable $key) {

    }

    public function pollFirst() {

    }

    public function pollFirstEntry() {

    }

    public function pollLast() {

    }

    public function pollLastEntry() {

    }

    public function containsAll(\blaze\collections\Map $c) {

    }

    public function removeAll(\blaze\collections\Map $obj) {

    }

    public function retainAll(\blaze\collections\Map $obj) {

    }

    public function subMap(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function tailMap(\blaze\lang\Reflectable $fromElement, $inclusive = true) {

    }

}

?>
