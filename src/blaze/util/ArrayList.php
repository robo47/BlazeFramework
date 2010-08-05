<?php
namespace blaze\util;
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
class ArrayList extends Object implements ListI{

    private $array = array();
    private $count = 0;

    public function __construct($array = null){
        if($array == null || !is_array($array))
            $this->array = new \ArrayObject();
        else
            $this->array = new \ArrayObject($array);
    }
     public function get($index){
        if($index < 0 || $index > $this->count)
            throw new \blaze\lang\IndexOutOfBoundsException($index);
        return $this->array[$index];
     }

     public function add($element){
        $this->array[] = $element;
        $this->count++;
     }

     public function count(){
        return $this->array->count();
     }
    public function offsetExists($offset) {
        return $this->array->offsetExists($offset);
    }
    public function offsetGet($offset) {
        return $this->array->offsetGet($offset);
    }
    public function offsetSet($offset, $value) {
        $this->array->offsetSet($offset, $value);
    }
    public function offsetUnset($offset) {
        $this->array->offsetUnset($offset);
    }
    public function getIterator() {
        return $this->array->getIterator();
    }
}

?>
