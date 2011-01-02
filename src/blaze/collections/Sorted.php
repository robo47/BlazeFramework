<?php

namespace blaze\collections;

/**
 * Implemenations of Sorted have to store objects in a sorted way which is specified
 * by the natural order of the data type or a given comparator.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0
 */
interface Sorted {

    /**
     * Returns the comparator used to order the elements in this set, or null if this set uses the natural ordering of its elements.
     * @return blaze\lang\Comparator
     */
    public function comparator();

    /**
     * Returns an iterator over the elements in this set, in descending order.
     * @return blaze\collections\Iterator
     */
    public function descendingIterator();

    /**
     * Returns the first (lowest) element currently in this set.
     * @return mixed
     */
    public function first();

    /**
     * Returns the last (highest) element currently in this set.
     * @return mixed
     */
    public function last();

    /**
     * Retrieves and removes the first (lowest) element, or returns null if this set is empty.
     * @return mixed
     */
    public function pollFirst();

    /**
     * Retrieves and removes the last (highest) element, or returns null if this set is empty.
     * @return mixed
     */
    public function pollLast();

    /**
     *  Returns the least element in this set greater than or equal to the given element, or null if there is no such element.
     * @return mixed
     */
    public function ceiling($element);

    /**
     *  Returns the greatest element in this set less than or equal to the given element, or null if there is no such element.
     * @return mixed
     */
    public function floor($element);

    /**
     * Returns the least element in this set strictly greater than the given element, or null if there is no such element.
     * @return mixed
     */
    public function higher($element);

    /**
     * Returns the greatest element in this set strictly less than the given element, or null if there is no such element.
     * @return mixed
     */
    public function lower($element);
}

?>
