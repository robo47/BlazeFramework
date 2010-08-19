<?php
namespace blaze\collections\map;
use blaze\lang\Object;

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

    private $data;

    public function __construct(\blaze\collections\Collection $collection = null){
        if($collection == null){
            $this->size = 0;
            $this->data = array();
        }

    }
    
    public function clear(){}
    public function containsKey($key){
        return array_key_exists($key->hashCode(), $this->data);
    }
    public function containsValue($value){
        return
    }
    public function entrySet(){}
    public function keySet(){}
    public function valueSet(){}
    public function get($key){
        if(array_key_exists($key->hashCode(), $this->data)){
            return $this->data[$key->hashCode()]->getValue();
        }
        return null;
    }
    public function put($key, $value){
        if($key instanceof Object){

            if(array_key_exists($key->hashCode(), $this->data)){
                $old =  $this->data[$key->hashCode()];
                $this->data[$key->hashCode()]->setValue($value);
                return $old->getValue();
            }
            $this->data[$key->hashCode()] = $value;
            return null;
            
        }
    }
    public function putAll(\blaze\collections\Map $m){}
    public function remove($key){}
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
    public function getIterator(){}

    public function containsAll(\blaze\collections\Map $c) {

    }

    public function removeAll(\blaze\collections\Map $obj) {

    }

    public function retainAll(\blaze\collections\Map $obj) {

    }


}
/**
 * @access private
 */
class Entry{
        private $key;
        private $value;

        public function  __construct($key, $value){
            if($key!=null){
                $this->key = $key;
                $this->value = $value;
            }
            else{
                throw new \blaze\lang\NullPointerException('Key must have a value!');
            }
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
   





?>