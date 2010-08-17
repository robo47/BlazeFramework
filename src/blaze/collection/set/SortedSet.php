<?php

namespace blaze\collection\map;

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
interface SortedSet extends \blaze\collection\Set {

    /**
     * Returns the comparator used to order the elements in this set, or null if this set uses the natural ordering of its elements.
     * @return blaze\lang\Comparator
     */
    public function comparator();

    /**
     * Returns an iterator over the elements in this set, in descending order.
     * @return blaze\collection\Iterator
     */
    public function descendingIterator();

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return SortedSet
     */
    public function descendingSet();

    /**
     * Returns the first (lowest) element currently in this set.
     */
    public function first();

    /**
     * Returns the last (highest) element currently in this set.
     */
    public function last();

    /**
     * Retrieves and removes the first (lowest) element, or returns null if this set is empty.
     */
    public function pollFirst();

    /**
     * Retrieves and removes the last (highest) element, or returns null if this set is empty.
     */
    public function pollLast();

    /**
     *  Returns the least element in this set greater than or equal to the given element, or null if there is no such element.
     */
    public function ceiling($element);

    /**
     *  Returns the greatest element in this set less than or equal to the given element, or null if there is no such element.
     */
    public function floor($element);

    /**
     * Returns the least element in this set strictly greater than the given element, or null if there is no such element.
     */
    public function higher($element);

    /**
     * Returns the greatest element in this set strictly less than the given element, or null if there is no such element.
     */
    public function lower($element);

    /**
     * @return blaze\collection\SortedSet
     */
    public function headSet($toElement, $inclusive = true);

    /**
     * @return blaze\collection\SortedSet
     */
    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * @return blaze\collection\SortedSet
     */
    public function tailSet($fromElement, $inclusive = true);
}

?>
