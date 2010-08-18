<?php

namespace blaze\collections\bag;

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
final class BoundedSortedBag implements SortedBag, \blaze\collections\Bounded {

    private $bag;
    private $maxCount;

    public function __construct(SortedBag $bag, $maxCount) {
        $this->bag = $bag;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function addCount($obj, $count) {

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

    public function descendingBag() {

    }

    public function descendingCollection() {

    }

    public function descendingIterator() {

    }

    public function first() {

    }

    public function floor($element) {

    }

    public function getCount($obj) {

    }

    public function headBag($toElement, $inclusive = true) {

    }

    public function headCollection($toElement, $inclusive = true) {

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

    public function removeCount($obj, $count) {

    }

    public function retainAll(Collection $obj) {

    }

    public function subBag($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {

    }

    public function tailBag($fromElement, $inclusive = true) {

    }

    public function tailCollection($fromElement, $inclusive = true) {

    }

    public function toArray($type = null) {

    }

    public function uniqueSet() {

    }

    

}

?>
