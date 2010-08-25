<?php
namespace blaze\collections;

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
interface ListI extends Collection{
     /**
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
      */
     public function get($index);
     /**
      * Returns the index of the first occurrence of the specified element in this list, or -1 if this list does not contain the element.
      */
     public function indexOf($obj);
     /**
      * Returns the index of the last occurrence of the specified element in this list, or -1 if this list does not contain the element.
      */
     public function lastIndexOf($obj);
     /**
      * Returns a list iterator of the elements in this list (in proper sequence), starting at the specified position in this list.
      */
     public function listIterator($index = 0);
     /**
      * Removes the element at the specified position in this list (optional operation).
      */
     public function removeAt($index);
     /**
      * Replaces the element at the specified position in this list with the specified element (optional operation).
      */
     public function set($index, $obj);
     /**
      * Returns a view of the portion of this list between the specified fromIndex, inclusive, and toIndex, exclusive.
      */
     public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false);



}

?>
