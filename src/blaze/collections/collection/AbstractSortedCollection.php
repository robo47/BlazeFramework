<?php

namespace blaze\collections\collection;

use blaze\lang\Object;

/**
 * Some basic implementations of a SortedCollection. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedCollection extends AbstractCollection implements \blaze\collections\collection\SortedCollection {

}

?>
