<?php

namespace blaze\collections\set;

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
final class BoundedSortedSet implements \blaze\collections\set\SortedSet, \blaze\collections\Bounded {

    private $set;
    private $maxCount;

    public function __construct(\blaze\collections\set\SortedSet $set, $maxCount) {
        $this->set = $set;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function ceiling($element) {

    }

    public function clear() {

    }

    public function comparator() {

    }

    public function contains($obj) {

    }

    public function containsAll(Collection $c) {

    }

    public function count() {

    }

    public function descendingCollection() {

    }

    public function descendingIterator() {

    }

    public function descendingSet() {

    }

    public function first() {

    }

    public function floor($element) {

    }

    public function headCollection($toElement, $inclusive = true) {

    }

    public function headSet($toElement, $inclusive = true) {

    }

    public function higher($element) {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function last() {

    }

    public function lower($element) {

    }

    public function maxCount() {

    }

    public function pollFirst() {

    }

    public function pollLast() {

    }

    public function remove($obj) {

    }

    public function removeAll(Collection $obj) {

    }

    public function retainAll(Collection $obj) {

    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function tailCollection($fromElement, $inclusive = true) {

    }

    public function tailSet($fromElement, $inclusive = true) {

    }

    public function toArray($type = null) {

    }

}

?>
