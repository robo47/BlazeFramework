<?php

namespace blaze\collections\bag;

/**
 * This class is an implementation of a SortedBag and keeps the elements ordered
 * in a sorted way. The sort order is specified through the result of a comparation
 * between two elements with the method Comparable#compareTo() or Comparator#compare()
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Implementation maybe with TreeMap and documentation.
 */
class TreeBag extends AbstractBag implements SortedBag {

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

    public function ceiling(\blaze\lang\Reflectable $element) {
        
    }

    public function comparator() {
        
    }

    public function contains(\blaze\lang\Reflectable $obj) {
        
    }

    public function descendingBag() {
        
    }

    public function descendingCollection() {
        
    }

    public function descendingIterator() {
        
    }

    public function first() {
        
    }

    public function floor(\blaze\lang\Reflectable $element) {
        
    }

    public function getCount(\blaze\lang\Reflectable $obj) {
        
    }

    public function headBag(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        
    }

    public function headCollection(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        
    }

    public function higher(\blaze\lang\Reflectable $element) {
        
    }

    public function last() {
        
    }

    public function lower(\blaze\lang\Reflectable $element) {
        
    }

    public function removeCount(\blaze\lang\Reflectable $obj, \int $count) {
        
    }

    public function subBag(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        
    }

    public function subCollection(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        
    }

    public function tailBag(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        
    }

    public function tailCollection(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        
    }

    public function uniqueSet() {
        
    }

    public function pollFirst() {

    }

    public function pollLast() {
        
    }

}

?>
