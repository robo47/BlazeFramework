<?php

namespace blaze\collections\queue;

/**
 * This is a basic implementation of a DequeDecorator which can be used to
 * give a Deque a different behaviour via the same interface by decorating it.
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

    public function addFirst(\blaze\lang\Reflectable $element) {
        return $this->deque->addFirst($element);
    }

    public function addLast(\blaze\lang\Reflectable $element) {
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

    public function removeFirstOccurrence(\blaze\lang\Reflectable $element) {
        return $this->deque->removeFirstOccurrence($element);
    }

    public function removeLast() {
        return $this->deque->removeLast();
    }

    public function removeLastOccurrence(\blaze\lang\Reflectable $element) {
        return $this->deque->removeLastOccurrence($element);
    }

}

?>
