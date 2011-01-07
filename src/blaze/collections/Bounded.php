<?php

namespace blaze\collections;

/**
 * This interface is used by Decorator implementations of the Collection API
 * to provide bounded collections. Every collection can be bounded with methods
 * of the class Collections.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     \blaze\collections\Collections
 * @since   1.0
 */
interface Bounded {

    /**
     * Returns true if this collections is full and no new elements can be added.
     * @return boolean
     */
    public function isFull();

    /**
     * Gets the maximum size of the collections
     * @return int
     */
    public function maxCount();
}

?>
