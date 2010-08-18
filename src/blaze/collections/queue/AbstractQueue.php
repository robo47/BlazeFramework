<?php
namespace blaze\collections\queue;
use blaze\lang\Object;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractQueue extends \blaze\collections\AbstractCollection implements \blaze\collections\Queue{
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
