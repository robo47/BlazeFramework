<?php
namespace blaze\collection\lists;
use blaze\lang\Object,
 blaze\collection\Collection,
blaze\collection\lists\AbstractList;

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


    public function add($obj){
        $this->elementData[$this->size++] = $obj;
        return true;
    }

    public function addAt($index , $obj){
            $this->RangeCheck();
            array_splice($this->elementData, $index, count($this->elementData), array_merge(array($obj), array_slice($this->elementData, $index)));
            $this->size++;
            return true;
        

    }

    public function addAllAt($index, Collection $c){
        $this->RangeCheck();
        $ar = $c->toArray();
        for($i = 0;i<count($ar);$i++){
            $this->addAt(($index)+$i, $ar[$i]);
        }

     }

     public function get($index){
         $this->RangeCheck();
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

     public function listIterator($index = 0){
         throw new \blaze\lang\NotYetImplenetedException('');
     }

     public function removeAt($index){
         throw new \blaze\lang\NotYetImplenetedException('');
     }

     public function set($index, $obj){
         $this->RangeCheck();
         $old = $this->elementData[$index];
         $this->elementData[$index] = $obj;
         return $old;
     }

     public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false){
         throw new \blaze\lang\NotYetImplenetedException('');
     }

    public function serialize() {

    }

    public function unserialize($serialized) {

    }

    private function RangeCheck(){
         if($index<0||$this->size<$index){
            throw new \blaze\lang\IndexOutOfBoundsException('Index: '.$index.' Size: '.$this->size);
        }
    }
}

?>

}

?>
