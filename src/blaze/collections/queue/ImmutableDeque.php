<?php

namespace blaze\collections\queue;

/**
 * A deque decorator which makes deques immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableDeque extends AbstractDequeDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function add($obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function offer($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function addFirst($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function addLast($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function offerFirst($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function offerLast($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the deque and returns false.
     */
    public function push($element) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the deque.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function pop() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeFirst() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function poll() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function pollFirst() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function pollLast() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeFirstOccurrence($element) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeLast() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeLastOccurrence($element) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function remove($obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the deque and returns null.
     */
    public function removeElement() {
        return null;
    }

}

?>
