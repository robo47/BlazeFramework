<?php
namespace blaze\collections;
use blaze\lang\Object;
/**
 * Keys and Values must be unique, looking up the key by a value
 * may not take longer than value by key. So there must be an inverted Map
 * which requires that values are unique.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface BidiMap extends Map{
    /**
     * Returns a set of all values in this map.
     *
     * @return blaze\collections\Set
     */
    public function valueSet();
    /**
     * Returns the key to the specified value of this map.
     *
     * @return mixed
     */
    public function getKey($value);
    /**
     * Removes the entry of the map and returns the key of the deleted entry.
     * 
     * @return mixed the key or null if nothing was removed
     */
    public function removeValue($value);
}

?>
