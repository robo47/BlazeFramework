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
    public function add(\blaze\lang\Reflectable $obj) {
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
    public function addAllAt(\int $index, \blaze\collections\Collection $c) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the list and returns false.
     */
    public function addAt(\int $index, \blaze\lang\Reflectable $obj) {
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
    public function remove(\blaze\lang\Reflectable $obj) {
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
    public function removeAt(\int $index) {
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
    public function set(\int $index, \blaze\lang\Reflectable $obj) {
        return false;
    }

}

?>
