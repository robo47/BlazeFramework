<?php
namespace blaze\collections\queue;
use blaze\lang\Object;

/**
 * Description of ArrayList
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class PriorityQueue extends AbstractQueue implements \blaze\io\Serializable{
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(Collection $obj){}
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
    public function containsAll(Collection $c){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(Collection $obj){}
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(Collection $obj){}
    /**
     * @return blaze\collections\ArrayObject
     */
    public function toArray($type = null){}
    /**
     * @return blaze\lang\Comparator
     */
    public function comparator(){
        
    }
    
    
    public function element() {
        
    }

    public function offer($element) {
        
    }

    public function peek() {
        
    }

    public function poll() {
        
    }

    public function removeElement() {
        
    }
    }

?>
