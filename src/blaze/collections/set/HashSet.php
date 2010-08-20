<?php
namespace blaze\collections\set;
use blaze\lang\Object,
  blaze\collections\map\HashMap,
  \blaze\lang\String,
  \blaze\lang\Integer;

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
class HashSet extends AbstractSet implements \blaze\lang\Cloneable, \blaze\io\Serializable{

    private $data;
    private $size;

    public function __construct(\blaze\collections\Collection $collection =null){
        if($collection==null){
            $this->data = array();
            $this->size = 0;
        }

    }

    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){
        if($this->contains($obj)){
            return false;
        }
        else{
            $hash = $this->hash($obj);
            $this->data[$hash]= $obj;
            $this->size++;
            return true;
        }
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(\blaze\collections\Collection $obj){
        $ar = $obj->toArray();
        $ret = false;
        foreach($ar as $value){
            if($this->add($value)){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * Removes all elements from this collections
     */
    public function clear(){
        $this->data = array();
        $this->size = 0;
    }

    public function isEmpty(){
        return $this->size==0;
    }

    public function getIterator(){
        return new HashSetIterator($this->data);
    }

    public function count(){
        return $this->size;
    }
    /**
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj){
        $hash = $this->hash($obj);
        return array_key_exists($hash, $this->data);
    
    }
    /**
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(\blaze\collections\Collection $c){
        $ar = $c->toArray();
        foreach($ar as $value){
            if(!$this->contains($value)){
                return false;
            }
        }
        return true;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj){
        if($this->contains($obj)){
            unset($this->data[$this->hash($obj)]);
            $this->size--;
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(\blaze\collections\Collection $obj){
        $ar = $obj->toArray();
        $ret = false;
        foreach($ar as $value){
            if($this->remove($value)){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(\blaze\collections\Collection $obj){
        throw new \blaze\lang\NotYetImplenetedException('retainALL');
    }
    /**
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null){
        $i = 0;
        $ar = array();
        foreach($this->data as $val){
            $ar[$i] = $val;
            $i++;
        }
        return $ar;
    }

    private function hash($key){
        if($key instanceof Object){
            return String::asNative ($key->hashCode());
        }
        else{
            return String::asNative (Integer::hexStringToInt(md5(String::asNative($key))));
        }

    }
}

class HashSetIterator implements \blaze\collections\Iterator{
     private $data;
 public function  __construct($data) {
        if(is_array($data)){
            $this->data = $data;
        }
        else{
            throw new \blaze\lang\IllegalArgumentException('data must be a Array!');
        }
    }
public function current() {
        return current($this->data);
    }

public function hasNext() {
      if(next($this->data)){
          prev($this->data);
          return true;
      }
      else{
          return false;
      }
    }

public function next() {
    return next($this->data);
    }
public function remove() {
      unset($this->data[$this->hash(curren($this->data))]);
    }
public function rewind() {
   reset($this->data);
    }
public function setValue($value) {
    $old = current($this->data);
    $this->data[$this->hash($old)] = $value;
    return $old;
    }
public function valid() {
       return (!(current($this->data)==false));
    }

    private function hash($key){
        if($key instanceof Object){
            return $key->hashCode();
        }
        else{
            Integer::hexStringToInt(md5($key));
        }

    }


public function key() {
        return current($this->hash($this->data));
    }


}

?>
