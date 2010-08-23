<?php
namespace blaze\collections\queue;
use blaze\lang\Object;

/**
 * Description of Stack
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
        return new StackIterator($this->data);
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

    public function remove($obj) {
        $index = $this->indexOf($obj);
        if ($index == -1) {
            return false;
        } else {
            for ($index; $index < $this->size; $index++) {
                $this->data[$index] = $this->data[($index + 1)];
            }
            unset($this->data[$index - 1]);
            $this->size--;
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
    /**
     *
     * @todo Beikov fragen!
     */
    public function element() {
        return $this->data[0];
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
        $index = array_search($obj, $this->data, true);
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

    public function __construct($data) {
        if (is_array($data)) {
            $this->data = $data;
        } else {
            throw new \blaze\lang\IllegalArgumentException('data must be a Array!');
        }
    }

    public function current() {
        return current($this->data);
    }


    public function hasNext() {
        if (next($this->data)) {
            prev($this->data);
            return true;
        } else {
            return false;
        }
    }

    public function key() {
        return \key($this->data);
    }

    public function next() {
        return next($this->data);
    }

    public function remove() {
        $index = $this->key();
        for ($i = $index; $i < \count($this->data); $i++) {
            $this->data[$i] = $this->data[($i + 1)];
        }
        unset($this->data[$i]);

    }

    public function rewind() {
        reset($this->data);
    }



    public function valid() {
        return (current($this->data) !== false);
    }

}

?>
