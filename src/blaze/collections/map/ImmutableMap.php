<?php

namespace blaze\collections\map;

/**
 * A map decorator which makes maps immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableMap extends AbstractMapDecorator implements \blaze\collections\Immutable {

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
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
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
    public function remove(\blaze\lang\Reflectable $key) {
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

}

?>
