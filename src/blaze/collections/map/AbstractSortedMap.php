<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * Some basic implementations of a SortedMap. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedMap extends AbstractMap implements \blaze\collections\map\SortedMap {

}

?>
