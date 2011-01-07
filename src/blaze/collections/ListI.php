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
     * @param mixed $element
     */
    public function addAt($index, $obj);

    /**
     * Inserts all of the elements in the specified collections into this list at the specified position (optional operation).
     * @param int $index
     * @param mixed $element
     */
    public function addAllAt($index, Collection $c);

    /**
     *  Returns the element at the specified position in this list.
     * @return mixed
     */
    public function get($index);

    /**
     * Returns the index of the first occurrence of the specified element in this list, or -1 if this list does not contain the element.
     * @return int the index
     */
    public function indexOf($obj);

    /**
     * Returns the index of the last occurrence of the specified element in this list, or -1 if this list does not contain the element.
     * @return int the index
     */
    public function lastIndexOf($obj);

    /**
     * Returns a list iterator of the elements in this list (in proper sequence), starting at the specified position in this list.
     * @return \blaze\collections\iterator\ListIterator
     */
    public function listIterator($index = 0);

    /**
     * Removes the element at the specified position in this list (optional operation).
     * @return boolean wether the action was successfull or not
     */
    public function removeAt($index);

    /**
     * Replaces the element at the specified position in this list with the specified element (optional operation).
     * @return mixed the element which was previously on the specified index
     */
    public function set($index, $obj);

    /**
     * Returns a view of the portion of this list between the specified fromIndex, inclusive, and toIndex, exclusive.
     * @return \blaze\collections\ListI
     */
    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false);
}

?>
