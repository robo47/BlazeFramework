<?php

namespace blaze\collections\set;

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
interface SortedSet extends \blaze\collections\Set, \blaze\collections\bag\SortedCollection {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return SortedSet
     */
    public function descendingSet();

    /**
     * @return blaze\collections\SortedSet
     */
    public function headSet($toElement, $inclusive = true);

    /**
     * @return blaze\collections\SortedSet
     */
    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * @return blaze\collections\SortedSet
     */
    public function tailSet($fromElement, $inclusive = true);
}

?>
