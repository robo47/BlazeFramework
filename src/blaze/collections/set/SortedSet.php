<?php

namespace blaze\collections\set;

/**
 * A sorted set is nearly like a normal set, with the difference that the elements
 * are ordered in a sorted way in the set. Because of this, the
 * comparable interface must be implemented by their elements or a comparator
 * has to be given.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SortedSet extends \blaze\collections\Set, \blaze\collections\bag\SortedCollection {

    /**
     * Returns a reverse order view of the elements contained in this set.
     * @return blaze\collections\SortedSet
     */
    public function descendingSet();

    /**
     * Returns a view of the current set which starts at the first element of the set
     * and ends at the element toElement.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $inclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedSet
     */
    public function headSet(\blaze\lang\Reflectable $toElement, $inclusive = true);

    /**
     * Returns a view of the current set which starts at the fromElement and ends
     * at toElement of the set.
     * @param mixed $fromElement The element which is the mark at which to start the view.
     * @param mixed $toElement The element which is the indicator at where to end the view.
     * @param boolean $fromInclusive Specifies wether the element fromElement is included in the view or not.
     * @param boolean $toInclusive Specifies wether the element toElement is included in the view or not.
     * @return blaze\collections\SortedSet
     */
    public function subSet(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true);

    /**
     * Returns a view of the current set which starts at the fromElement and ends
     * at the end of the set.
     * @param mixed $fromElement The element which is the indicator at where to start the view.
     * @param boolean $inclusive Specifies wether the element fromElement is included in the view or not.
     * @return blaze\collections\SortedSet
     */
    public function tailSet(\blaze\lang\Reflectable $fromElement, $inclusive = true);
}

?>
