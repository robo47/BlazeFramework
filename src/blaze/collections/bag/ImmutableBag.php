<?php

namespace blaze\collections\bag;

/**
 * A bag decorator which makes bags immutable.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class ImmutableBag extends AbstractBagDecorator implements \blaze\collections\Immutable {

    /**
     * {@inheritDoc}
     * Adds nothing to the bag and returns false.
     */
    public function add(\blaze\lang\Reflectable $obj) {
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
    public function addCount(\blaze\lang\Reflectable $obj, \int $count) {
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
    public function remove(\blaze\lang\Reflectable $obj) {
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
    public function removeCount(\blaze\lang\Reflectable $obj, \int $count) {
        return null;
    }

    /**
     * {@inheritDoc}
     * Removes nothing from the bag and returns null.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

}

?>
