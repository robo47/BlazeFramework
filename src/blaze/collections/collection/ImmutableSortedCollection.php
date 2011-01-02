<?php

namespace blaze\collections\collection;

/**
 * A sorted collection decorator which makes sorted collections immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableSortedCollection extends AbstractSortedCollectionDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the collection and returns false.
     */
    public function add($obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the collection and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the collection.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the collection and returns null.
     */
    public function remove($obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the collection and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the collection and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

}

?>
