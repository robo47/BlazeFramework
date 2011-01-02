<?php

namespace blaze\collections\lists;

/**
 * A list decorator which makes lists immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableList extends AbstractListDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the list and returns false.
     */
    public function add($obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the list and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the list and returns false.
     */
    public function addAllAt($index, \blaze\collections\Collection $c) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the list and returns false.
     */
    public function addAt($index, $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the list.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the list and returns null.
     */
    public function remove($obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the list and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the list and returns null.
     */
    public function removeAt($index) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the list and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Sets nothing in the list and returns false.
     */
    public function set($index, $obj) {
        return false;
    }
}

?>
