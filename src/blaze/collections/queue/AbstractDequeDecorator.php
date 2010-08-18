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
abstract class AbstractDequeDecorator extends AbstractQueueDecorator implements \blaze\collections\queue\Deque {

    public function __construct(\blaze\collections\queue\Deque $deque) {
        parent::__construct($deque);
    }

    public function addFirst($element) {
        return $this->queue->addFirst($element);
    }

    public function addLast($element) {
        return $this->queue->addLast($element);
    }

    public function descendingIterator() {
        return $this->queue->descendingIterator();
    }

    public function getFirst() {
        return $this->queue->getFirst();
    }

    public function getLast() {
        return $this->queue->getLast();
    }

    public function offerFirst($element) {
        return $this->queue->offerFirst($element);
    }

    public function offerLast($element) {
        return $this->queue->offerLast($element);
    }

    public function peekFirst() {
        return $this->queue->peekFirst();
    }

    public function peekLast() {
        return $this->queue->peekLast();
    }

    public function pollFirst() {
        return $this->queue->pollFirst();
    }

    public function pollLast() {
        return $this->queue->pollLast();
    }

    public function pop() {
        return $this->queue->pop();
    }

    public function push($element) {
        return $this->queue->push($element);
    }

    public function removeFirst() {
        return $this->queue->removeFirst();
    }

    public function removeFirstOccurrence($element) {
        return $this->queue->removeFirstOccurrence($element);
    }

    public function removeLast() {
        return $this->queue->removeLast();
    }

    public function removeLastOccurrence($element) {
        return $this->queue->removeLastOccurrence($element);
    }

}

?>
