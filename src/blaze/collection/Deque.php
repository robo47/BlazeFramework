<?php
namespace blaze\collection;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Deque.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Deque extends \blaze\collection\Queue{
    /**
     * @return boolean
     */
     public function addFirst($element);
    /**
     * @return boolean
     */
     public function addLast($element);
     /**
      * Retrieves, but does not remove, the first element of this deque.
      */
     public function getFirst();
     /**
      * Retrieves, but does not remove, the last element of this deque.
      */
     public function getLast();
     /**
      * Retrieves and removes the head of this queue.
      * @return Iterator
      */
     public function descendingIterator();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function offerFirst($element);
     /**
      * Retrieves and removes the head of this queue.
      */
     public function offerLast($element);
     /**
      * Retrieves and removes the head of this queue.
      */
     public function peekFirst();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function peekLast();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function pollFirst();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function pollLast();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function pop();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function push($element);
     /**
      * Retrieves and removes the head of this queue.
      */
     public function removeFirst();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function removeFirstOccurrence($element);
     /**
      * Retrieves and removes the head of this queue.
      */
     public function removeLast();
     /**
      * Retrieves and removes the head of this queue.
      */
     public function removeLastOccurrence($element);
}

?>
