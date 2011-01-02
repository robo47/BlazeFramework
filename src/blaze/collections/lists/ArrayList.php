<?php

namespace blaze\collections\lists;

use blaze\lang\Object;

/**
 * A dynamic growing array which implements the ListI interface and offers fast
 * access.
 *
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Tuning and documentation.
 */
class ArrayList extends AbstractList implements \blaze\lang\Cloneable, \blaze\io\Serializable {

    private $elementData;
    private $size;

    /**
     * @param \blaze\collections\Collection|\blaze\collections\ArrayI|array $collectionOrArray
     */
    public function __construct( $collectionOrArray = null) {
        if ($collectionOrArray !== null) {
            if($collectionOrArray instanceof blaze\collections\Collection){
                $this->elementData = $collectionOrArray->toArray();
                $this->size = count($this->elementData);
            } else if($collectionOrArray instanceof \blaze\collections\ArrayI || is_array($collectionOrArray)) {
                $this->size = count($collectionOrArray);
                $this->elementData = array();

                foreach($collectionOrArray as $elem){
                    $this->elementData[] = $elem;
                }
            }else{
                throw new \blaze\lang\IllegalArgumentException('Invalid type for parameter');
            }
        }else{
            $this->size = 0;
                $this->elementData = array();
        }
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj) {
        $this->elementData[$this->size++] = $obj;
        return true;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj) {
        $this->rangeCheck($index);
        $ar = $obj->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            $this->add($ar[$i]);
        }
    }

    public function addAllAt($index, \blaze\collections\Collection $c) {
        $this->rangeCheck($index);
        $ar = $c->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            $this->addAt(($index) + $i, $ar[$i]);
        }
    }

    public function addAt($index, $obj) {
        $this->rangeCheck($index);
        array_splice($this->elementData, $index, count($this->elementData), array_merge(array($obj), array_slice($this->elementData, $index)));
        $this->size++;
        return true;
    }

    /**
     * Removes all elements from this collections
     */
    public function clear() {
        $this->elementData = array();
        $this->size = 0;
    }

    public function isEmpty() {
        return $this->size == 0;
    }

    public function getIterator() {
        return new ArrayListIterator($this->elementData,$this);
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj) {
        if ($this->indexOf($obj) == -1)
            return false;
        else
            return true;
    }

    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c) {
        $ar = $c->toArray();
        for ($i = 0; $i < count($ar); $i++) {
            if ($this->indexOf($ar[$i]) == -1) {
                return false;
            }
        }
        return true;
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

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        $ar = $obj->toArray();
        $ret = false;
        for ($i = 0; $i < count($ar); $i++) {
            if ($this->remove($ar[$i])) {
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        if (!$this->containsAll($obj)) {
            return false;
        }
        $diff = array_diff($this->elementData, $obj->toArray());

        $ret = false;

        foreach($diff as $val){
            $index = $this->indexOf($val);
            if($index!==-1){
                $ret = true;
                unset($this->elementData[$index]);
                $this->size--;
            }
          
        }

        $this->elementData = \array_keys($this->elementData);
  

        return $ret;
    }

    /**
     * @return blaze\collections\ArrayObject
     */
    public function toArray($type = null) {
        return $this->elementData;
    }

    public function get($index) {
        $this->rangeCheck($index);
        return $this->elementData[$index];
    }

    public function indexOf($obj) {
        $index = array_search($obj, $this->elementData,false);
        if (\is_int($index)) {
            return $index;
        } else {
            return -1;
        }
    }

    public function lastIndexOf($obj) {
        for ($i = $this->size - 1; $i >= 0; $i--)
            if ($obj === $this->elementData[$i])
                return $i;
    }

    public function listIterator($index = 0) {
        $this->rangeCheck($index);
        return new ListArrayListIterator($this->elementData,$this,$index);
    }

    public function removeAt($index) {
        $this->rangeCheck($index);
        $ret = $this->elementData[$index];
        unset($this->elementData[$index]);
        $this->elementData = \array_values($this->elementData);
        $this->size--;
        return $ret;
    }

    public function set($index, $obj) {
        $this->rangeCheck($index);
        $old = $this->elementData[$index];
        $this->elementData[$index] = $obj;
        return $old;
    }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {
        if (!$fromInclusive) {
            $fromIndex++;
        }
        if ($toInclusive) {
            $toIndex++;
        }
        $this->rangeCheck($fromIndex);
        $this->rangeCheck($toIndex);
        $ret = new ArrayList();
        for ($i = $fromIndex; $i < $toIndex; $i++) {
            $ret->add($this->elementData[$i]);
        }
        return $ret;
    }

    private function rangeCheck($index) {
        if ($index < 0 || $this->size < $index) {
            throw new \blaze\lang\IndexOutOfBoundsException('Index: ' . $index . ' Size: ' . $this->size);
        }
    }

     protected function removeRange($fromIndex,$toIndex){
         $this->rangeCheck($fromIndex);
         $this->rangeCheck($toIndex-1);
         $i;
         for($i=$fromIndex;$i<$toIndex;$i++){
             $this->removeAt($i);
         }
     }

}

class ArrayListIterator implements \blaze\collections\Iterator {

    private $data;
    private $index = 0;
    private $arraylist;

    public function __construct(&$data,$arraylist) {
        $this->data = $data;
        $this->arraylist = $arraylist;
    }

    public function current() {
        if (!$this->check($this->index))
            throw new \blaze\lang\IndexOutOfBoundsException($this->index);
        return $this->data[$this->index];
    }

    public function hasNext() {
        return $this->check($this->index + 1);
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index++;
        if($this->valid())
            return $this->current();
        else
            return null;
    }

    public function remove() {
        if ($this->valid())
            $this->arraylist->removeAt($this->index);
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return $this->check($this->index);
    }

    private function check($index) {
        return array_key_exists($index, $this->data);
    }

}

class ListArrayListIterator implements \blaze\collections\iterator\ListIterator{

    private $data;
    private $index;
    private $arraylist;

    public function __construct(&$data,&$arraylist, $index) {
        $this->data = $data;
        $this->arraylist = $arraylist;
        $this->index = $index;
    }
public function add($value) {
        $this->arraylist->add($value);
    }


public function hasPrevious() {
       return $this->check($this->index-1);
    }


public function nextIndex() {
        if($this->check($this->index+1)){
            return $this->index+1;
        }
        else{
            return count($this->data);
        }
    }
public function previous() {
        if($this->check($this->index-1)){
            return $this->data[$this->index-1];
        }
        else{
            throw new \blaze\lang\IndexOutOfBoundsException('Has no Previous');
        }
    }
public function previousIndex() {
        if($this->check($this->index-1)){
            return $this->index-1;
        }
        else{
           return -1;
        }
    }

public function set($value) {
        $this->data[$this->index] =$value;
    }



    public function current() {
        if (!$this->check($this->index))
            throw new \blaze\lang\IndexOutOfBoundsException($this->index);
        return $this->data[$this->index];
    }

    public function hasNext() {
        return $this->check($this->index + 1);
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index++;
        if($this->check($this->index)){
            return $this->current();
        }
        else{
            return false;
        }
    }

    public function remove() {
        if ($this->valid())
            $this->arraylist->removeAt($this->index);
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return $this->check($this->index);
    }

    private function check($index) {
        return array_key_exists($index, $this->data);
    }
}

/* * class ArrayListIterator implements \blaze\collections\Iterator {

  private $data;

  public function __construct(&$data) {
  $this->data = $data;
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
  return key($this->data);
  }

  public function next() {
  return next($this->data);
  }

  public function remove() {
  unset($this->data[$this->key()]);
  }

  public function rewind() {
  reset($this->data);
  }

  public function valid() {
  return (current($this->data) !== false);
  }

  }* */
?>
