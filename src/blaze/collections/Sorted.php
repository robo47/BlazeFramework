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
     * @return \blaze\lang\Reflectable
     */
    public function first();

    /**
     * Returns the last (highest) element currently in this set.
     * @return \blaze\lang\Reflectable
     */
    public function last();

    /**
     * Retrieves and removes the first (lowest) element, or returns null if this set is empty.
     * @return \blaze\lang\Reflectable
     */
    public function pollFirst();

    /**
     * Retrieves and removes the last (highest) element, or returns null if this set is empty.
     * @return \blaze\lang\Reflectable
     */
    public function pollLast();

    /**
     *  Returns the least element in this set greater than or equal to the given element, or null if there is no such element.
     * @param \blaze\lang\Reflectable $element
     * @return \blaze\lang\Reflectable
     */
    public function ceiling(\blaze\lang\Reflectable $element);

    /**
     *  Returns the greatest element in this set less than or equal to the given element, or null if there is no such element.
     * @param \blaze\lang\Reflectable $element
     * @return \blaze\lang\Reflectable
     */
    public function floor(\blaze\lang\Reflectable $element);

    /**
     * Returns the least element in this set strictly greater than the given element, or null if there is no such element.
     * @param \blaze\lang\Reflectable $element
     * @return \blaze\lang\Reflectable
     */
    public function higher(\blaze\lang\Reflectable $element);

    /**
     * Returns the greatest element in this set strictly less than the given element, or null if there is no such element.
     * @param \blaze\lang\Reflectable $element
     * @return \blaze\lang\Reflectable
     */
    public function lower(\blaze\lang\Reflectable $element);
}

?>
