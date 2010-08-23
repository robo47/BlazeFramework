<?php
namespace blaze\collections\queue;
use blaze\lang\Object;

/**
 * Description of ArrayList
 *
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Stack extends \blaze\collections\queue\AbstractQueue{

    private $data;
    private $size;

    public function __construct(){
        $this->data = array();
        $this->size = 0;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){
        $this->data[$size] = $obj;
        $this->size++;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj){
        foreach($obj as $val){
            $this->add($val);
        }
    }
    /**
     * Removes all elements from this collections
     */
    public function clear(){
        $this->data = array();
        $this->size = 0;
    }

    public function isEmpty(){
        return $this->size == 0;
    }

    public function getIterator(){}

    public function count(){
        return $this->size;
    }
    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj){
        return \in_array($obj, $this->data);
    }
    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c){
        foreach($c as $val){
            if(!$this->contains($val)){
                return false;
            }
        }
        return true;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($index){
         $this->rangeCheck($index);
        for ($i = $index; $i < $this->size; $i++) {
            $this->data[$i] = $this->data[($i + 1)];
        }
        unset($this->data[$i]);
        $this->size--;

        return true;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj){
        $ret = false;
        foreach($obj as $val){
            if($this->removeElement($val)&&$ret == false){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj){}
    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null){
        return $this->data;
    }

    public function element() {

    }

    public function offer($element) {

    }

    public function peek() {
        if($this->size == 0){
            throw new \blaze\lang\NullPointerException('Stack is empty!');
        }
        return $this->data[($this->size-1)];

    }

    public function poll() {

    }

    public function removeElement($obj) {
        if(\in_array($obj,$this->data)){
            $index = $this->search($obj);
            if(\is_int($index)){
                $index++;
                return $this->remove($index);
            }
        }
        return false;
    }

    public function pop(){
        $ret = $this->data[(--$this->size)];
        unset ($this->data[($this->size+1)]);
        return $ret;
    }
    public function push($element){
        $this->add($element);
    }
    /**
     *
     * @param <type> $element
     * @return int Returns the 1-based position where an object is on this stack.
     */
    public function search($element){
        return (\array_search($element,$this->data)+1);
    }
    private function rangeCheck($index) {
        if ($index < 0 || $this->size < $index) {
            throw new \blaze\lang\IndexOutOfBoundsException('Index: ' . $index . ' Size: ' . $this->size);
        }
    }

}

?>
