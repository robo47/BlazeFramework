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
interface SortedCollection extends \blaze\collections\Collection, Sorted {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return SortedCollection
     */
    public function descendingCollection();

    /**
     * @return blaze\collections\SortedCollection
     */
    public function headCollection($toElement, $inclusive = true);

    /**
     * @return blaze\collections\SortedCollection
     */
    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * @return blaze\collections\SortedCollection
     */
    public function tailCollection($fromElement, $inclusive = true);
}

?>
