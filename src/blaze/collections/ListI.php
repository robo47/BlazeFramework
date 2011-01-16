<?php

namespace blaze\collections;

/**
 * Implementations of this interface are similar to an dynamic growing array
 * offering index based storing of objects on operating with them.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ListI extends Collection {

    /**
     * Adds the object to the specified index
     * @param int $index
     * @param \blaze\lang\Reflectable  $element
     */
    public function addAt(\int $index, \blaze\lang\Reflectable $obj);

    /**
     * Inserts all of the elements in the specified collections into this list at the specified position (optional operation).
     * @param int $index
     * @param Collection c
     */
    public function addAllAt(\int $index, Collection $c);

    /**
     *  Returns the element at the specified position in this list.
     * @return \blaze\lang\Reflectable
     */
    public function get(\int $index);

    /**
     * Returns the index of the first occurrence of the specified element in this list, or -1 if this list does not contain the element.
     * @param \blaze\lang\Reflectable $obj
     * @return int the index
     */
    public function indexOf(\blaze\lang\Reflectable $obj);

    /**
     * Returns the index of the last occurrence of the specified element in this list, or -1 if this list does not contain the element.
     * @param \blaze\lang\Reflectable $obj
     * @return int the index
     */
    public function lastIndexOf(\blaze\lang\Reflectable $obj);

    /**
     * Returns a list iterator of the elements in this list (in proper sequence), starting at the specified position in this list.
     * @return \blaze\collections\iterator\ListIterator
     */
    public function listIterator($index = 0);

    /**
     * Removes the element at the specified position in this list (optional operation).
     * @return boolean wether the action was successfull or not
     */
    public function removeAt(\int $index);

    /**
     * Replaces the element at the specified position in this list with the specified element (optional operation).
     * @param \blaze\lang\Reflectable $obj
     * @return mixed the element which was previously on the specified index
     */
    public function set(\int $index, \blaze\lang\Reflectable $obj);

    /**
     * Returns a view of the portion of this list between the specified fromIndex, inclusive, and toIndex, exclusive.
     * @return \blaze\collections\ListI
     */
    public function subList(\int $fromIndex, \int $toIndex, $fromInclusive = true, $toInclusive = false);
}

?>
