<?php
namespace blaze\collection;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://commons.apache.org/collections/api-release/index.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
      * @return blaze\collection\Set
      */
     public function uniqueSet();
}

?>
