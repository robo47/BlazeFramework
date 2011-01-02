<?php

namespace blaze\collections\bag;

/**
 * A sorted bag decorator which makes sorted bags immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableSortedBag extends AbstractSortedBagDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the bag and returns false.
     */
    public function add($obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the bag and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the bag and returns false.
     */
    public function addCount($obj, $count) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the bag.
     */
    public function clear() {
        return;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function remove($obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function removeCount($obj, $count) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function pollFirst() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function pollLast() {
        return null;
    }
}

?>
