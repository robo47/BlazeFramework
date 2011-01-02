<?php

namespace blaze\collections\map;

/**
 * A sorted map decorator which makes sorted maps immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableSortedMap extends AbstractSortedMapDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Does not clear the map.
     */
    public function clear() {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the map and returns false.
     */
    public function put($key, $value) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Adds nothing to the map and returns false.
     */
    public function putAll(\blaze\collections\Map $m) {
        return false;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function remove($key) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function removeAll(\blaze\collections\Map $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function retainAll(\blaze\collections\Map $obj) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function pollFirst() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function pollFirstEntry() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function pollLast() {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the map and returns null.
     */
    public function pollLastEntry() {
        return null;
    }

}

?>
