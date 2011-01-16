<?php

namespace blaze\collections\queue;

/**
 * A queue decorator which makes queues immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableQueue extends AbstractQueueDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the queue and returns false.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the queue and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the queue and returns false.
     */
    public function offer(\blaze\lang\Reflectable $element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the queue.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the queue and returns null.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the queue and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the queue and returns null.
     */
    public function removeElement() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the queue and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the queue and returns null.
     */
    public function poll() {
        return null;
    }

}

?>
