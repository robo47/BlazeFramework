<?php

namespace blaze\collections\bag;

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
class AbstractBag extends \blaze\collections\AbstractCollection implements \blaze\collections\Bag {

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj){}
    /**
     * Removes all elements from this collections
     */
    public function clear(){}

    public function isEmpty(){}

    public function getIterator(){}

    public function count(){}
    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj){}
    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj){}
    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null){}
    
public function addCount($obj, $count) {
        
    }
public function getCount($obj) {

    }
public function removeCount($obj, $count) {
        
    }
public function uniqueSet() {

    }
}

?>
