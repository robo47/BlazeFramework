<?php

namespace blaze\collections;

use blaze\lang\Object;

/**
 * Represents an entry which is stored within a map.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     \blaze\collections\Map
 * @since   1.0
 */
interface MapEntry {

    /**
     * Returns the key of the entry.
     * @return \blaze\lang\Reflectable
     */
    public function getKey();

    /**
     * Returns the value of the entry.
     * @return \blaze\lang\Reflectable
     */
    public function getValue();

    /**
     * Sets the value of the entry, by setting the value the map has to be affected.
     * @param \blaze\lang\Reflectable  $value
     */
    public function setValue(\blaze\lang\Reflectable $value);
}

?>
