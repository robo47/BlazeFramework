<?php

namespace blaze\collections\queue;

/**
 * A deque decorator which specifies bounds for a deque
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedDeque extends AbstractDequeDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the deque
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a deque which is bounded.
     *
     * @param \blaze\collections\queue\Deque $deque The decorated deque
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\queue\Deque $deque, $maxCount) {
        parent::__construct($deque);
        $this->maxCount = $maxCount;
    }

    public function isFull() {
        return $this->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function add($obj) {
        if (!$this->isFull())
            return $this->queue->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->queue->addAll($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function offer($element) {
        if (!$this->isFull())
            return $this->queue->offer($element);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function addFirst($element) {
        if (!$this->isFull())
            return $this->queue->addFirst($element);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function addLast($element) {
        if (!$this->isFull())
            return $this->queue->addLast($element);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function offerFirst($element) {
        if (!$this->isFull())
            return $this->queue->offerFirst($element);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function offerLast($element) {
        if (!$this->isFull())
            return $this->queue->offerLast($element);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the deque is full nothing is added and false is returned.
     */
    public function push($element) {
        if (!$this->isFull())
            return $this->queue->push($element);
        else
            return false;
    }

}

?>
