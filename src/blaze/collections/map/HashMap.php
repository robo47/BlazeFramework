<?php
namespace blaze\collections\map;
use blaze\lang\Object,
blaze\lang\Integer,
        blaze\lang\String;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read int $length
 * @author  Oliver Kotzina
 * @todo    Implementing and documenting.
 */
class HashMap extends AbstractMap implements \blaze\lang\Cloneable, \blaze\io\Serializable {

    private $size;
    /**
     *
     * @var array[blaze\collections\MapEntry]
     */
    private $data;

    public function __construct(\blaze\collections\Map $collection = null){
        if($collection == null){
            $this->size = 0;
            $this->data = array();
        }
        else{
            
        }
    }
    
    public function clear(){
        $this->size = 0;
        $this->data = array();
    }

    public function containsKey($key){
        return array_key_exists($this->hash($key), $this->data);
    }

    public function containsValue($value){
        foreach($this->data as &$val){
            if($val->getValue()==$value){
                return true;
            }
        }
        return false;
    }

    public function entrySet(){}
    public function keySet(){}
    public function valueSet(){}

    public function get($key){
        $hash = $this->hash($key);
        if(array_key_exists($hash, $this->data)){
            return $this->data[$hash]->getValue();
        }
        return null;
    }
    public function put($key, $value){
            $hash=$this->hash($key);

            if(array_key_exists($hash, $this->data)){
                $old =  $this->data[$hash];
                $this->data[$hash]->setValue($value);
                return $old->getValue();
            }
            $this->data[$hash] = new Entry($key, $value);
            $this->size++;
            return null; 
        }  
    
    public function putAll(\blaze\collections\Map $m){
        foreach($m as $value){
            $this->put($value->getKey(), $value->getValue());
        }
    }


    public function remove($key){
        $hash =  $this->hash($key);
        
         if($this->containsKey($key)){
            unset($this->data[$hash]);
            return true;
         }
         else{
             return false;
         }
    }

    public function values(){}

    public function isEmpty(){
        return $this->size ==0;
    }


    public function count(){
        return $this->size;
    }
    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator(){
        return new HashMapIterator($this->data);
    }

    public function containsAll(\blaze\collections\Map $c) {
        foreach($c as $val){
            \var_dump($val);
            if(!$this->containsKey($val->getKey())){
                var_dump($val);
                return false;
            }
            
        }
        return true;

    }

    public function removeAll(\blaze\collections\Map $obj) {
        foreach($obj as $value){
            if(!$this->remove($value->getKey())){
                return false;
            }
        }
        return true;
    }

    public function retainAll(\blaze\collections\Map $obj) {
        throw new \blaze\lang\NotYetImplenetedException('HAHA');
        }

    private function hash($key){
        if($key instanceof Object){
            return String::asNative ($key->hashCode());
        }
        else{
            return String::asNative (Integer::hexStringToInt(md5($key)));
        }

    }

    public function toString(){
        $str = new \blaze\lang\StringBuffer('HashMap:{');
        foreach($this->data as $val){
            $str->append(' ['.$val->getKey().','.$val->getValue().']');
        }
        $str->append('}');
    }

}
/**
 * @access private
 */
class Entry implements \blaze\collections\MapEntry{
        private $key;
        private $value;

        public function  __construct($key, $value){
           
                $this->key = $key;
                $this->value = $value;
       
         
        }

        public function getKey(){
            return $this->key;
        }

        public function getValue(){
            return $this->value;
        }
        public function setValue($value){
            $old = $this->value;
            $this->value = $value;
            return $old;
        }

}
/**
 * @access private
 */
class HashMapIterator implements \blaze\collections\MapIterator{
    /**
     *
     * @var array[blaze\collections\MapEntry]
     */
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
public function getKey() {
        return current($this->data)->getKey();
    }
public function getValue() {
        return current($this->data)->getValue();
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
public function key() {
 return $this->getKey();
    }
public function next() {
    return next($this->data);
    }
public function remove() {
      unset($this->data[$this->hash($this->getKey())]);
    }
public function rewind() {
   reset($this->data);
    }
public function setValue($value) {
    $entry = current($this->data);
    $old = $entry->getValue();
    $entry = $value;
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
}
   





?>