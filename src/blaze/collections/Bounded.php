<?php
namespace blaze\collections;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Bounded{
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
