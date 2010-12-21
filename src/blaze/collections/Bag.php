<?php
namespace blaze\collections;

/**
 * A bag is something like a Map for a specific object as key and an integer as value.
 * The key can be any object and the value is the count of how often such an object
 * has been added to the bag.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://commons.apache.org/collectionss/api-release/index.html
 * @since   1.0
 */
interface Bag extends Collection{
     /**
      * Adds $count copies of the specified object to the Bag.
      * @param mixed $obj
      */
     public function addCount($obj, $count);
     /**
      * Returns the number of occurrences (cardinality) of the given object currently in the bag.
      * @param mixed $obj
      * @return boolean
      */
     public function getCount($obj);
     /**
      * Removes $count copies of the specified object from the Bag.
      * @return boolean
      */
     public function removeCount($obj, $count);
     /**
      * Returns a Set of unique elements in the Bag.
      * @return blaze\collections\Set
      */
     public function uniqueSet();
}

?>
