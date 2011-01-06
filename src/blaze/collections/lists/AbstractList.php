<?php
namespace blaze\collections\lists;
use blaze\lang\Object,
 blaze\collections\Collection;

/**
 * Some basic implementations of a List. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 */
abstract class AbstractList extends \blaze\collections\collection\AbstractCollection implements \blaze\collections\ListI{
   
}

?>
