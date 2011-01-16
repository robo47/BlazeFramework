<?php

namespace blaze\collections\collection;

/**
 * A sorted collection is nearly like a normal collection, with the difference that the elements
 * are ordered in a sorted way in the collection. Because of this, the
 * comparable interface must be implemented by their elements or a comparator
 * has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SortedCollection extends \blaze\collections\Collection, \blaze\collections\Sorted {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return blaze\collections\SortedCollection
     */
    public function descendingCollection();

    /**
     * Returns a view on this collection which starts at the first element and ends
     * at toElement.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $inclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedCollection
     */
    public function headCollection(\blaze\lang\Reflectable $toElement, $inclusive = true);

    /**
     * Returns a view of the current collection which starts at the fromElement and ends
     * at toElement of the collection.
     * @param mixed $fromElement The element which is the mark at which to start the view.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $fromInclusive Specifies wether the element fromElement is included in the view or not.
     * @param boolean $toInclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedCollection
     */
    public function subCollection(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * Returns a view of the current collection which starts at the fromElement and ends
     * at the end of the collection.
     * @param mixed $fromElement The element which is the indicator at where to start the view.
     * @param boolean $inclusive Specifies wether the element fromElement is included in the view or not.
     * @return blaze\collections\SortedCollection
     */
    public function tailCollection(\blaze\lang\Reflectable $fromElement, $inclusive = true);
}

?>
