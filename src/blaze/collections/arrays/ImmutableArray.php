<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * Uses the decorator pattern and only overrides the methods which are needed to
 * provide immutability.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
final class ImmutableArray extends AbstractArrayDecorator {

    /**
     *
     * @access private
     */
    public function offsetSet($offset, $value) {
        return false;
    }

    /**
     *
     * @access private
     */
    public function offsetUnset($offset) {
        return false;
    }
}

?>