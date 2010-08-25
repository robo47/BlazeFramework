<?php
namespace blaze\collections;
use blaze\collections\Collection;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Collections.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Collections extends \blaze\lang\Object{

    private function __construct(){}
    
    /**
     *
     * @param Collection $c 
     * @param mixed
     */
    public function addAll(Collection $c, $varArgs){
        $args = func_get_args();
        $c = array_shift($args);
        foreach($args as $arg){
            $c->add($arg);
        }
    }

    /**
     * Looks for a key in the list and returns the index of it.
     * Checks wether the list is typed or not. If it is not typed, then the
     * array has to be converted into one. The comparator can only be used for
     * arrays which manage objects.
     *
     * @see http://download.oracle.com/javase/6/docs/api/java/util/Arrays.html#binarySearch%28java.lang.Object[],%20int,%20int,%20java.lang.Object%29
     * @param ListI $a
     * @param mixed $key
     * @param \blaze\lang\Comparator $c
     * @return int
     * @throws blaze\lang\IndexOutOfBoundsException
     */
    public static function binarySearch(ListI $a, $key, \blaze\lang\Comparator $c = null){}
    /**
     * This method is the same as binarySearch with the exception that a range
     * can be given in which shall be searched for the key.
     *
     * @param ListI $a
     * @param mixed $key
     * @param int $fromIndex The index where to start at in the array
     * @param int $toIndex The index where to stop at in the array
     * @param blaze\lang\Comparator $c
     * @return int
     * @throws blaze\lang\IndexOutOfBoundsException
     */
    public static function binaryRangeSearch(ListI $a, $key, $fromIndex, $toIndex, \blaze\lang\Comparator $c = null){}
    /**
     * Copies the src into dest
     * @param blaze\collections\ListI $src
     * @param blaze\collections\ListI $dest
     */
    public static function copyOf(ListI $src, ListI $dest){
        $dest->clear();
        foreach($src as $value){
            $dest->add($value);
        }
    }
    /**
     * Copies a subpart of the list src into dest
     * @param blaze\collections\ListI $src
     * @param blaze\collections\ListI $dest
     */
    public static function copyOfRange(ListI $src, $from, $to, ListI $dest){
        $dest->clear();
        $iterator = $src->listIterator($from);
        for ($iterator->rewind();$iterator->valid();$iterator->next()) {
            $key   = $iterator->key();
            if($key>=$to){
                break;
            }
           $dest->add($iterator->current());
    }
    }
    /**
     * Assigns value to every element of the array
     */
    public static function fill(ListI $a, $value){
       $size =  $a->count();
       $a->clear();
       for($i = 0;$i<$size;$i++){
           $a->add($value);
       }
    }
    /**
     * Assigns value to every element of the subpart of the array
     */
    public static function fillRange(ListI $a, $from, $to, $value){
        $a->clear();
        for($i = $from; $i<$to;$i++){
            $a->add($value);
        }
    }
    /**
     *  Returns the starting position of the first occurrence of the specified target list within the specified source list, or -1 if there is no such occurrence.
     */
    public static function indexOfSubList(ListI $src, ListI $target){}
    /**
     * Returns the starting position of the last occurrence of the specified target list within the specified source list, or -1 if there is no such occurrence.
     */
    public static function lastIndexOfSubList(ListI $src, ListI $target){}
    /**
     *  Returns the maximum element of the given collection, according to the order induced by the specified comparator
     */
    public static function max(Collection $src, \blaze\lang\Comparator $comp = null){}
    /**
     * Returns the minimum element of the given collection, according to the natural ordering of its elements.
     */
    public static function min(Collection $src, \blaze\lang\Comparator $comp = null){}
    /**
     *  Replaces all occurrences of one specified value in a list with another.
     */
    public static function replaceAll(ListI $src, $oldVal, $newVal){}
    /**
     *  Reverses the order of the elements in the specified list.
     */
    public static function reverse(ListI $src){

    }
    /**
     *  Returns a comparator that imposes the reverse ordering of the specified comparator.
     *  If no Comparator is given, it returns a comparator that imposes the reverse of the natural ordering on a collection of objects that implement the Comparable interface.
     */
    public static function reverseComperator(\blaze\lang\Comparator $comp = null){}
    /**
     * Sorts the list.
     * The comparator can only be used for lists which manage objects.
     */
    public static function sort(ListI &$list, \blaze\lang\Comparator $c = null){
        Collections::sortRange($list, 0, $list->count()-1);
    }
    /**
     * Same as sort but for a specific range.
     */
    public static function sortRange(ListI &$list, $from, $to, \blaze\lang\Comparator $c = null){
        $size = $list->count();

        if($size<=0){
            throw new \blaze\lang\IndexOutOfBoundsException('List has not any Values');
        }
        if($size<=$to||$to<0){
            throw new \blaze\lang\IndexOutOfBoundsException('Index : size: '.$size.' to: '.$to);
        }
        if($size<=$from||$from<0){
            throw new \blaze\lang\IndexOutOfBoundsException('Index : size: '.$size.' to: '.$from);
        }
        $ar = $list->subList($from, $to);
        $ar = $ar->toArray();
        if($c===null){
            usort($ar, array('\blaze\collections\Collections','cmpObjects'));
        }
        else{
           usort($ar, array($c,'compare'));
        }
        $newlist = new lists\ArrayList();
        $newlist->addAll($list->subList(0, $from));
        foreach($ar as $val){
            $newlist->add($val);
        }
        $newlist->addAll($list->subList($to, $size-1,true,true));
        $list = $newlist;

    }

    private static function cmpObjects( $a,  $b){
        return $a->compareTo($b);
    }
    /**
     * Swaps the element from posA with posB
     */
    public static function swap(ListI $list, $posA, $posB){}
    /**
     * Returns true if the two arrays are deeply equal
     * @return boolean
     */
    public static function deepEquals(ArrayObject $a1, ArrayObject $a2){}
    
    /**
     * Returns a bounded Collection and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Collection
     * @return blaze\collection\Collection
     */
    public static function boundedCollection(Collection $obj, $maxSize){
        return new collection\BoundedCollection($obj, $maxSize);
    }
    /**
     * Returns a bounded SortedCollection and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedCollection
     * @return blaze\collection\collection\SortedCollection
     */
    public static function boundedSortedCollection(blaze\collection\collection\SortedCollection $obj, $maxSize){
        return new collectio\BoundedSortedCollection($obj, $maxSize);
    }
    /**
     * Returns a bounded Bag and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Bag
     * @return blaze\collection\Bag
     */
    public static function boundedBag(Bag $obj, $maxSize){
        return new bag\BoundedBag($obj, $maxSize);
    }
    /**
     * Returns a bounded SortedBag and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedBag
     * @return blaze\collection\bag\SortedBag
     */
    public static function boundedSortedBag(blaze\collection\bag\SortedBag $obj, $maxSize){
        return new bag\BoundedSortedBag($obj, $maxSize);
    }
    /**
     * Returns a bounded Set and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Set
     * @return blaze\collection\Set
     */
    public static function boundedSet(Set $obj, $maxSize){
        return new set\BoundedSet($obj, $maxSize);
    }
    /**
     * Returns a bounded SortedSet and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedSet
     * @return blaze\collection\set\SortedSet
     */
    public static function boundedSortedSet(blaze\collection\set\SortedSet $obj, $maxSize){
        return new set\BoundedSortedSet($obj, $maxSize);
    }
    /**
     * Returns a bounded ListI and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the ListI
     * @return blaze\collection\ListI
     */
    public static function boundedList(blaze\collection\ListI $obj, $maxSize){
        return new lists\BoundedList($obj, $maxSize);
    }
    /**
     * Returns a bounded Map and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Map
     * @return blaze\collection\Map
     */
    public static function boundedMap(Map $obj, $maxSize){
        return new map\BoundedMap($obj, $maxSize);
    }
    /**
     * Returns a bounded SortedMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedMap
     * @return blaze\collection\map\SortedMap
     */
    public static function boundedSortedMap(blaze\collection\map\SortedMap $obj, $maxSize){
        return new map\BoundedSortedMap($obj, $maxSize);
    }
    /**
     * Returns a bounded BidiMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the BidiMap
     * @return blaze\collection\BidiMap
     */
    public static function boundedBidiMap(BidiMap $obj, $maxSize){
        return new bidimap\BoundedBidiMap($obj, $maxSize);
    }
    /**
     * Returns a bounded SortedBidiMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedBidiMap
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function boundedSortedBidiMap(blaze\collection\bidimap\SortedBidiMap $obj, $maxSize){
        return new bidimap\BoundedSortedBidiMap($obj, $maxSize);
    }

    /**
     * Returns an immutable Collection and cuts of the elements which are to much
     * @return blaze\collection\Collection
     */
    public static function immutableCollection(Collection $obj){
        return new collection\ImmutableCollection($obj);
    }
    /**
     * Returns an immutable SortedCollection and cuts of the elements which are to much
     * @return blaze\collection\collection\SortedCollection
     */
    public static function immutableSortedCollection(blaze\collection\collection\SortedCollection $obj){
        return new collection\ImmutableSortedCollection($obj);
    }
    /**
     * Returns an immutable Bag and cuts of the elements which are to much
     * @return blaze\collection\Bag
     */
    public static function immutableBag(Bag $obj){
        return new bag\ImmutableBag($obj);
    }
    /**
     * Returns an immutable SortedBag and cuts of the elements which are to much
     * @return blaze\collection\bag\SortedBag
     */
    public static function immutableSortedBag(blaze\collection\bag\SortedBag $obj){
        return new bag\ImmutableSortedBag($obj);
    }
    /**
     * Returns an immutable Set and cuts of the elements which are to much
     * @return blaze\collection\Set
     */
    public static function immutableSet(Set $obj){
        return new set\ImmutableSet($obj);
    }
    /**
     * Returns an immutable SortedSet and cuts of the elements which are to much
     * @return blaze\collection\set\SortedSet
     */
    public static function immutableSortedSet(blaze\collection\set\SortedSet $obj){
        return new set\ImmutableSortedSet($obj);
    }
    /**
     * Returns an immutable SortedBidiMap and cuts of the elements which are to much
     * @return blaze\collection\ListI
     */
    public static function immutableList(blaze\collection\ListI $obj){
        return new lists\ImmutableList($obj);
    }
    /**
     * Returns an immutable Map and cuts of the elements which are to much
     * @return blaze\collection\Map
     */
    public static function immutableMap(Map $obj){
        return new map\ImmutableMap($obj);
    }
    /**
     * Returns an immutable SortedMap and cuts of the elements which are to much
     * @return blaze\collection\map\SortedMap
     */
    public static function immutableSortedMap(blaze\collection\map\SortedMap $obj){
        return new map\ImmutableSortedMap($obj);
    }
    /**
     * Returns an immutable BidiMap and cuts of the elements which are to much
     * @return blaze\collection\BidiMap
     */
    public static function immutableBidiMap(BidiMap $obj){
        return new bidimap\ImmutableBidiMap($obj);
    }
    /**
     * Returns an immutable SortedBidiMap and cuts of the elements which are to much
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function immutableSortedBidiMap(blaze\collection\bidimap\SortedBidiMap $obj){
        return new bidimap\ImmutableSortedBidiMap($obj);
    }

    /**
     * Returns a typed Collection and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Collection
     */
    public static function typedCollection(Collection $obj, $type){
        return new collection\TypedCollection($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed SortedCollection and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\collection\SortedCollection
     */
    public static function typedSortedCollection(blaze\collection\collection\SortedCollection $obj, $type){
        return new collection\TypedSortedCollection($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed Bag and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Bag
     */
    public static function typedBag(Bag $obj, $type){
        return new bag\TypedBag($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed SortedBag and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\bag\SortedBag
     */
    public static function typedSortedBag(blaze\collection\bag\SortedBag $obj, $type){
        return new bag\TypedSortedBag($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed Set and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Set
     */
    public static function typedSet(Set $obj, $type){
        return new set\TypedSet($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed SortedSet and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\set\SortedSet
     */
    public static function typedSortedSet(blaze\collection\set\SortedSet $obj, $type){
        return new set\TypedSortedSet($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed SortedBidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\ListI
     */
    public static function typedList(blaze\collection\ListI $obj, $type){
        return new lists\TypedList($obj, TypeChecker::getInstance($type));
    }
    /**
     * Returns a typed Map and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Map
     */
    public static function typedMap(Map $obj, $keyType, $valueType){
        return new map\TypedMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }
    /**
     * Returns a typed SortedMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\map\SortedMap
     */
    public static function typedSortedMap(blaze\collection\map\SortedMap $obj, $keyType, $valueType){
        return new map\TypedSortedMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }
    /**
     * Returns a typed BidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\BidiMap
     */
    public static function typedBidiMap(BidiMap $obj, $keyType, $valueType){
        return new bidimap\TypedBidiMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }
    /**
     * Returns a typed SortedBidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function typedSortedBidiMap(blaze\collection\bidimap\SortedBidiMap $obj, $keyType, $valueType){
        return new bidimap\TypedSortedBidiMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }
}

?>
