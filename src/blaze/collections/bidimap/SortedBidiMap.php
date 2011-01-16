<?php

namespace blaze\collections\bidimap;

/**
 * A sorted bidimap is like a normal bidimap, with the difference that the elements
 * are ordered in a sorted way in the map. Because of this, the
 * comparable interface must be implemented by their elements or a comparator
 * has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SortedBidiMap extends \blaze\collections\BidiMap, \blaze\collections\map\SortedMap {

}

?>
