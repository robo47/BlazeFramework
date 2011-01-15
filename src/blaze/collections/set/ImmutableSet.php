<?php

namespace blaze\collections\set;

/**
 * A set decorator which makes sets immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableSet extends AbstractSetDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the set and returns false.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the set and returns false.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Does not clear the set.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the set and returns null.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the set and returns null.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the set and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

}

?>
