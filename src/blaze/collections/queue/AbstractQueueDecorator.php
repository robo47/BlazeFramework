<?php

namespace blaze\collections\queue;

/**
 * This is a basic implementation of a QueueDecorator which can be used to
 * give a Queue a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractQueueDecorator extends \blaze\collections\collection\AbstractCollectionDecorator implements \blaze\collections\Queue {

    /**
     * The decorated queue.
     * @var \blaze\collections\Queue
     */
    protected $queue;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\Queue $queue The decorated queue.
     */
    public function __construct(\blaze\collections\Queue $queue) {
        parent::__construct($queue);
        $this->queue = $queue;
    }

    public function element() {
        return $this->queue->element();
    }

    public function offer(\blaze\lang\Reflectable $element) {
        return $this->queue->offer($element);
    }

    public function peek() {
        return $this->queue->peek();
    }

    public function poll() {
        return $this->queue->poll();
    }

    public function removeElement() {
        return $this->queue->removeElement();
    }

}

?>
