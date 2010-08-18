<?php
namespace blaze\collections\lists;
use blaze\lang\Object,
 blaze\collections\Collection;

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
class ArrayList extends AbstractList implements \blaze\lang\Cloneable, \blaze\io\Serializable{

    private $elementData;

    private $size;
    
    public function __construct(Collection $collection = null){
        if($collection!=null){
            $this->elementData = $collection->toArray();
            $this->size = count($this->elementData);
        }
        else{
                $this->size = 0;
                $this->elementData = array();
        }
    }
    /**
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj){
        $this->elementData[$this->size++] = $obj;
        return true;
    }
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

    
    public function addAllAt($index, Collection $c) {
        $this->rangeCheck();
        $ar = $c->toArray();
        for($i = 0;i<count($ar);$i++){
            $this->addAt(($index)+$i, $ar[$i]);
        }
    }

    public function addAt($index, $obj) {
        $this->rangeCheck();
            array_splice($this->elementData, $index, count($this->elementData), array_merge(array($obj), array_slice($this->elementData, $index)));
            $this->size++;
            return true;
    }

    public function get($index) {
        $this->rangeCheck();
            return $this->elementData[$index];
    }

    public function indexOf($obj){
         $index = array_search($obj, $this->elementData,true);
         if(\is_int($index)){
             return $index;
         }
         else{
             return -1;
         }
     }

     public function lastIndexOf($obj){
         for ($i = $this->size-1; $i >= 0; $i--)
		if ($obj===$this->elementData[$i])
		    return $i;
     }


    public function listIterator($index = 0) {
        
    }

    public function removeAt($index) {
        
    }

    public function set($index, $obj){
         $this->rangeCheck();
         $old = $this->elementData[$index];
         $this->elementData[$index] = $obj;
         return $old;
     }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {

    }

    private function rangeCheck(){
         if($index<0||$this->size<$index){
            throw new \blaze\lang\IndexOutOfBoundsException('Index: '.$index.' Size: '.$this->size);
        }
    }

}

?>
