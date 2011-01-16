<?php

namespace blaze\collections\bag;

/**
 * A sorted bag is like a normal bag, with the difference that the elements
 * are ordered in a sorted way in the collection. Because of this, the
 * comparable interface must be implemented by their elements or a comparator
 * has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SortedBag extends \blaze\collections\Bag, \blaze\collections\collection\SortedCollection {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return blaze\collections\bag\SortedBag
     */
    public function descendingBag();

    /**
     * Returns a view of the current bag which starts at the first element of the bag
     * and ends at the element toElement.
     * @param \blaze\lang\Reflectable  $toElement The element which is the indicator at where to end the view.
     * @param boolean $inclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\bag\SortedBag
     */
    public function headBag(\blaze\lang\Reflectable $toElement, $inclusive = true);

    /**
     * Returns a view of the current bag which starts at the fromElement and ends
     * at toElement of the bag.
     * @param \blaze\lang\Reflectable  $fromElement The element which is the mark at which to start the view.
     * @param \blaze\lang\Reflectable  $toElement The element which is the indicator at where to end the view.
     * @param boolean $fromInclusive Specifies wether the element fromElement is included in the view or not.
     * @param boolean $toInclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\bag\SortedBag
     */
    public function subBag(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * Returns a view of the current bag which starts at the fromElement and ends
     * at the end of the bag.
     * @param \blaze\lang\Reflectable  $fromElement The element which is the indicator at where to start the view.
     * @param boolean $inclusive Specifies wether the element fromElement is included in the view or not.
     * @return blaze\collections\bag\SortedBag
     */
    public function tailBag(\blaze\lang\Reflectable $fromElement, $inclusive = true);
}

?>
