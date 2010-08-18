<?php

namespace blaze\collections\bag;

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
interface SortedBag extends \blaze\collections\Bag, \blaze\collections\SortedCollection {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return SortedBag
     */
    public function descendingBag();

    /**
     * @return blaze\collections\SortedBag
     */
    public function headBag($toElement, $inclusive = true);

    /**
     * @return blaze\collections\SortedBag
     */
    public function subBag($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * @return blaze\collections\SortedBag
     */
    public function tailBag($fromElement, $inclusive = true);
}

?>
