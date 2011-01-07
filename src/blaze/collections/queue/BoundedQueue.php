<?php

namespace blaze\collections\queue;

/**
 * A queue decorator which specifies bounds for a queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedQueue extends AbstractQueueDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the queue
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a queue which is bounded.
     *
     * @param \blaze\collections\Queue $queue The decorated queue
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\Queue $queue, $maxCount) {
        parent::__construct($queue);
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
     * When the queue is full nothing is added and false is returned.
     */
    public function add($obj) {
        if (!$this->isFull())
            return $this->queue->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the queue has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->queue->addAll($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the queue is full nothing is added and false is returned.
     */
    public function offer($element) {
        if (!$this->isFull())
            return $this->queue->offer($element);
        else
            return false;
    }

}

?>
