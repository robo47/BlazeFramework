<?php
namespace blaze\collections\bag;

/**
 * Some basic implementations of a Bag. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractBag extends \blaze\collections\collection\AbstractCollection implements \blaze\collections\Bag {

}

?>
