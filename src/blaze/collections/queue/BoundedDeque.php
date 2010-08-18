<?php

namespace blaze\collections\queue;

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
final class BoundedDeque implements \blaze\collections\queue\Deque, \blaze\collections\Bounded {

    private $deque;
    private $maxCount;

    public function __construct(\blaze\collections\queue\Deque $deque, $maxCount) {
        $this->deque = $deque;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function addFirst($element) {

    }

    public function addLast($element) {

    }

    public function clear() {

    }

    public function contains($obj) {

    }

    public function containsAll(Collection $c) {

    }

    public function count() {

    }

    public function descendingIterator() {

    }

    public function element() {

    }

    public function getFirst() {

    }

    public function getLast() {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function maxCount() {

    }

    public function offer($element) {

    }

    public function offerFirst($element) {

    }

    public function offerLast($element) {

    }

    public function peek() {

    }

    public function peekFirst() {

    }

    public function peekLast() {

    }

    public function poll() {

    }

    public function pollFirst() {

    }

    public function pollLast() {

    }

    public function pop() {

    }

    public function push($element) {

    }

    public function remove($obj) {

    }

    public function removeAll(Collection $obj) {

    }

    public function removeElement() {

    }

    public function removeFirst() {

    }

    public function removeFirstOccurrence($element) {

    }

    public function removeLast() {

    }

    public function removeLastOccurrence($element) {

    }

    public function retainAll(Collection $obj) {

    }

    public function toArray($type = null) {

    }

}

?>
