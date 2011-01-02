<?php
namespace blaze\collections\queue;
use blaze\lang\Object;

/**
 * A stack is an implementation of a queue which follows the last-in-first-out principle.
 * 
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/1.4.2/docs/api/java/util/Stack.html
 * @since   1.0
 * @todo    Tuning, extending the class to be more java like and documentation.
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
        $this->data[$this->size] = $obj;
        $this->size++;
        return true;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj){
        $ar = $obj->toArray();
        foreach($ar as $val){
            $this->add($val);
        }
        return true;
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

    public function getIterator(){
        return new StackIterator($this->data, $this);
    }

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
        $ar = $c->toArray();
        foreach($ar as $val){
            if(!$this->contains($val)){
                return false;
            }
        }
        return true;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAt($index){
        $this->rangeCheck($index);
        $ret = $this->data[$index];
        unset($this->data[$index]);
        $this->data = \array_values($this->data);
        $this->size--;
        return $ret;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */

    public function remove($obj) {
        $index = $this->indexOf($obj);
        if($index ===-1){
            return false;
        }else{
            $this->removeAt($index);
            return true;
        }
    }

    public function removeAll(\blaze\collections\Collection $obj){
        $ret = false;
        $ar = $obj->toArray();
        foreach($ar as $val){
            if($this->remove($val)){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj){
        $reomve = \array_diff($this->data, $obj->toArray());
        $ret = false;
        foreach($reomve as $val){
            if($this->remove($val)){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null){
        return $this->data;
    }
   
    public function element() {
        return $this->peek();
    }

    public function offer($element) {
        return $this->add($element);

    }

    public function peek() {
        if($this->size == 0){
            return null;
        }
        return $this->data[($this->size-1)];

    }

    public function poll() {
        $ret =$this->peek();
        if($ret!=null){
            $this->removeAt($this->size-1);
        }
        return $ret;

    }
     public function indexOf($obj) {
         $help = \array_reverse($this->data,true);
        $index = array_search($obj, $help, true);
        if (\is_int($index)) {
            return $index;
        } else {
            return -1;
        }
    }

  

    public function removeElement() {
       return  $this->poll();
    }

    public function pop(){
         $ret =$this->peek();
        if($ret!=null){
            $this->removeAt($this->size-1);
        }
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
        $ret = \array_search($element,$this->data);
        if($ret ===false){
            return false;
        }
        return $ret+1;
    }
    private function rangeCheck($index) {
        if ($index < 0 || $this->size < $index) {
            throw new \blaze\lang\IndexOutOfBoundsException('Index: ' . $index . ' Size: ' . $this->size);
        }
    }

    public function toString(){
        $ret = 'Stack: ';
        foreach ($this->data as $val){
            $ret = $ret.$val.'|';
        }
        return $ret;
    }

}

/**
 * @access private
 */
class StackIterator implements \blaze\collections\Iterator{


    private $data;
    private $index;
    /**
     *
     * @var Stack
     */
    private $stack;

    public function __construct(&$data,  Stack $stack) {
        $this->data =  $data;
        $this->index = (count($this->data)-1);
        $this->stack = $stack;
    }

    public function current() {
        if (!$this->check($this->index))
            throw new \blaze\lang\IndexOutOfBoundsException($this->index);
        return $this->data[$this->index];
    }

    public function hasNext() {
        return $this->check($this->index -1);
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index--;
        //return $this->current();
    }

    public function remove() {
        $this->stack->removeAt($this->index);

    }

    public function valid() {
        return $this->check($this->index);
    }

    public function rewind() {
        $this->index = (count($this->data)-1);
    }

    private function check($index) {
        return array_key_exists($index, $this->data);
    }


}

?>
