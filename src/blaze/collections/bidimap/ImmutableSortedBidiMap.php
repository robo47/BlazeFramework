<?php

namespace blaze\collections\bidimap;

/**
 * A sorted bidimap decorator which makes sorted bidimaps immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableSortedBidiMap extends AbstractSortedBidiMapDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Does not clear the bidimap.
     */
    public function clear() {
        return;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the bidimap and returns false.
     */
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the bidimap and returns false.
     */
    public function putAll(\blaze\collections\Map $m) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function remove(\blaze\lang\Reflectable $key) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function removeAll(\blaze\collections\Map $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function retainAll(\blaze\collections\Map $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function removeValue(\blaze\lang\Reflectable $value) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function pollFirst() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function pollFirstEntry() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function pollLast() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bidimap and returns null.
     */
    public function pollLastEntry() {
        return null;
    }

}

?>
