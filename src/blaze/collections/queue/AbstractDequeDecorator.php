<?php

namespace blaze\collections\queue;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractDequeDecorator extends AbstractQueueDecorator implements \blaze\collections\queue\Deque {

    /**
     *
     * @var \blaze\collections\queue\Deque
     */
    protected $deque;

    public function __construct(\blaze\collections\queue\Deque $deque) {
        parent::__construct($deque);
        $this->deque = $deque;
    }

    public function addFirst($element) {
        return $this->deque->addFirst($element);
    }

    public function addLast($element) {
        return $this->deque->addLast($element);
    }

    public function descendingIterator() {
        return $this->deque->descendingIterator();
    }

    public function getFirst() {
        return $this->deque->getFirst();
    }

    public function getLast() {
        return $this->deque->getLast();
    }

    public function removeFirst() {
        return $this->deque->removeFirst();
    }

    public function removeFirstOccurrence($element) {
        return $this->deque->removeFirstOccurrence($element);
    }

    public function removeLast() {
        return $this->deque->removeLast();
    }

    public function removeLastOccurrence($element) {
        return $this->deque->removeLastOccurrence($element);
    }

}

?>
