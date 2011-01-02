<?php
/**
 * This package contains implementations of the Set interface.
 */
namespace blaze\collections\set;
use blaze\lang\Object;

/**
 * Some basic implementations of a Set. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSet extends \blaze\collections\collection\AbstractCollection implements \blaze\collections\Set{
    
}

?>
