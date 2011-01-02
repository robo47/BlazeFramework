<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * Uses the decorator pattern and only overrides the methods which are needed to
 * provide immutability.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
final class ImmutableArray extends AbstractArrayDecorator {

    /**
     * Nothing gets set, because it is immutable.
     */
    public function offsetSet($offset, $value) {}

    /**
     * Nothing gets unset, because it is immutable.
     */
    public function offsetUnset($offset) { }
}

?>