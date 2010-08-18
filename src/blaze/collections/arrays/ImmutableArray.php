<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read int $length
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
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