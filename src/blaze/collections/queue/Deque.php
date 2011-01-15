<?php

namespace blaze\collections\queue;

/**
 * A collection with which operations can be done at two ends.
 * At the beginning and ant the end. For capacity restrictions look at
 * BoundedDeque.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Deque.html
 * @since   1.0
 */
interface Deque extends \blaze\collections\Queue {

    /**
     * Inserts element at the beginning of the deque.
     * @return boolean True on success, otherwise false.
     */
    public function addFirst(\blaze\lang\Reflectable $element);

    /**
     * Inserts element at the end of the deque.
     * @return boolean True on success, otherwise false.
     */
    public function addLast(\blaze\lang\Reflectable $element);

    /**
     * Retrieves, but does not remove, the first element of this deque.
     * @return mixed
     */
    public function getFirst();

    /**
     * Retrieves, but does not remove, the last element of this deque.
     * @return mixed
     */
    public function getLast();

    /**
     * Retrieves and removes the first element of this deque.
     * @return mixed
     */
    public function removeFirst();

    /**
     * Retrieves and removes the last element of this deque.
     * @return mixed
     */
    public function removeLast();

    /**
     * Removes the first occurrence of element from this deque.
     * @return boolean True if an element was removed, otherwise false.
     */
    public function removeFirstOccurrence(\blaze\lang\Reflectable $element);

    /**
     * Removes the last occurrence of element from this deque.
     * @return boolean True if an element was removed, otherwise false.
     */
    public function removeLastOccurrence(\blaze\lang\Reflectable $element);

    /**
     * Returns an iterator for this deque in reverse order.
     * @return \blaze\collections\Iterator
     */
    public function descendingIterator();
}

?>
