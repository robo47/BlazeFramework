<?php
/**
 * This package contains classes for generic data storage.
 */
namespace blaze\collections;

use blaze\collections\Collection;

/**
 * This class offers static methods for operating with collections. For operations
 * with arrays see below.
 *
 * @author  Christian Beikov , Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     \blaze\collections\Arrays
 * @since   1.0
 */
class Collections extends \blaze\lang\Object implements \blaze\lang\StaticInitialization{

    /**
     * The empty immutable list
     * @var \blaze\collections\ListI
     */
    public static $EMPTY_LIST;
    /**
     * The empty immutable map
     * @var \blaze\collections\Map
     */
    public static $EMPTY_MAP;
    /**
     * The empty immutable set
     * @var \blaze\collections\Set
     */
    public static $EMPTY_SET;

    public static function staticInit() {
        self::$EMPTY_LIST = self::immutableList(new lists\ArrayList());
        self::$EMPTY_MAP = self::immutableMap(new map\HashMap());
        self::$EMPTY_SET = self::immutableSet(new set\HashSet());
    }

    private function __construct() {
        
    }

    /**
     * Adds all elements of the variable arguments to the collection $c.
     * @param Collection $c The collection into which the elements shall be added to.
     * @param mixed The elements(varargs) which shall be added.
     */
    public function addAll(Collection $c, $varArgs) {
        $args = func_get_args();
        $c = array_shift($args);
        foreach ($args as $arg) {
            $c->add($arg);
        }
    }

    /**
     * Looks for a key in the list and returns the index of it.
     * Checks wether the list is typed or not. If it is not typed, then the
     * array has to be converted into one. The comparator can only be used for
     * arrays which manage objects.
     *
     * @param ListI $a
     * @param mixed $key
     * @param \blaze\lang\Comparator $c
     * @return int
     * @throws blaze\lang\IndexOutOfBoundsException
     */
    public static function binarySearch(ListI $a, $key, \blaze\lang\Comparator $c = null) {
        $ar = $a->toArray();
        if($c==null){
            return Collections::arrayBsearch($key, $ar);
        }
        else{
            return Collections::arrayBsearchComperator($key, $ar, $c);
        }
    }

   private static function arrayBsearch($needle, $haystack) {
        $high = Count( $haystack ) -1;
        $low = 0;
       
        while ( $high >= $low ){
            $probe = Floor( ( $high + $low ) / 2 );
            $comparison = $haystack[$probe]->compareTo($needle );
            if ( $comparison < 0 ) {
                $low = $probe +1;
            } elseif ( $comparison > 0 ) {
                $high = $probe -1;
            } else {
                return $probe;
            }
        }
     
      // ---The loop ended without a match
      return -1;
    }

    private static function arrayBsearchComperator( $needle, $haystack, $cmp) {
        $high = Count( $haystack ) -1;
        $low = 0;

        while ( $high >= $low ){
            $probe = Floor( ( $high + $low ) / 2 );
            $comparison = $cmp->compare($haystack[$probe],$needle );
            if ( $comparison < 0 ) {
                $low = $probe +1;
            } elseif ( $comparison > 0 ) {
                $high = $probe -1;
            } else {
                return $probe;
            }
        }

      // ---The loop ended without a match
      return -1;
    }

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
    public static function binaryRangeSearch(ListI $a, $key, $fromIndex, $toIndex, \blaze\lang\Comparator $c = null) {
        return Collections::binarySearch($a->subList($fromIndex, $toIndex), $key, $c);
    }

    /**
     * Copies the src into dest
     * @param blaze\collections\ListI $src
     * @param blaze\collections\ListI $dest
     */
    public static function copyOf(ListI $src, ListI $dest) {
        $dest->clear();
        foreach ($src as $value) {
            $dest->add($value);
        }
    }

    /**
     * Copies a subpart of the list src into dest
     * @param blaze\collections\ListI $src
     * @param blaze\collections\ListI $dest
     */
    public static function copyOfRange(ListI $src, $from, $to, ListI $dest) {
        $dest->clear();
        $iterator = $src->listIterator($from);
        for($i = $from; $i<$to;$i++)
        {
            $dest->add($src->get($i));
        }
    }

    /**
     * Assigns value to every element of the array
     */
    public static function fill(ListI $a, $value) {
        $size = $a->count();
        $a->clear();
        for ($i = 0; $i < $size; $i++) {
            $a->add($value);
        }
    }

    /**
     * Assigns value to every element of the subpart of the array
     */
    public static function fillRange(ListI $a, $from, $to, $value) {
        for ($i = $from; $i < $to; $i++) {
            $a->set($i,$value);
        }
    }

    /**
     *  Returns the starting position of the first occurrence of the specified target list within the specified source list, or -1 if there is no such occurrence.
     */
    public static function indexOfSubList(ListI $src, ListI $target) {
        
    }

    /**
     * Returns the starting position of the last occurrence of the specified target list within the specified source list, or -1 if there is no such occurrence.
     */
    public static function lastIndexOfSubList(ListI $src, ListI $target) {
        
    }

    /**
     *  Returns the maximum element of the given collection, according to the order induced by the specified comparator
     */
    public static function max(Collection $src, \blaze\lang\Comparator $comp = null) {
        $list = new lists\ArrayList($src);
        Collections::sort($list,$comp);
        return $list->get($list->count()-1);
    }

    /**
     * Returns the minimum element of the given collection, according to the natural ordering of its elements.
     */
    public static function min(Collection $src, \blaze\lang\Comparator $comp = null) {
        $list = new lists\ArrayList($src);
        Collections::sort($list,$comp);
        return $list->get(0);
    }

    /**
     *  Replaces all occurrences of one specified value in a list with another.
     */
    public static function replaceAll(ListI $src, $oldVal, $newVal) {
       while(($index=$src->indexOf($oldVal))!=-1){
           $src->set($index, $newVal);
       }
    }

    /**
     *  Reverses the order of the elements in the specified list.
     */
    public static function reverse(ListI $src) {
        $ar = \array_reverse($src->toArray());
        $ret = new lists\ArrayList();
        foreach($ar as $val){
            $ret->add($val);
        }
        $src = $ret;
    }

    /**
     *  Returns a comparator that imposes the reverse ordering of the specified comparator.
     *  If no Comparator is given, it returns a comparator that imposes the reverse of the natural ordering on a collection of objects that implement the Comparable interface.
     */
    public static function reverseComperator(\blaze\lang\Comparator $comp = null) {
        
    }

    /**
     * Sorts the list.
     * The comparator can only be used for lists which manage objects.
     */
    public static function sort(ListI $list, \blaze\lang\Comparator $c = null) {
        Collections::sortRange($list, 0, $list->count());
    }

    /**
     * Same as sort but for a specific range.
     */
    public static function sortRange(ListI $list, $from, $to, \blaze\lang\Comparator $c = null) {
        $size = $list->count();

        if ($size <= 0) {
            throw new \blaze\lang\IndexOutOfBoundsException('List has not any Values');
        }
        if (($size+1) < $to || $to < 0) {
            throw new \blaze\lang\IndexOutOfBoundsException('size: ' . $size . ' to: ' . $to);
        }
        if ($size <= $from || $from < 0) {
            throw new \blaze\lang\IndexOutOfBoundsException('size: ' . $size . ' to: ' . $from);
        }
        $ar = $list->subList($from, $to);
        $ar = $ar->toArray();
        if ($c === null) {
            usort($ar, array('\blaze\collections\Collections', 'cmpObjects'));
        } else {
            usort($ar, array($c, 'compare'));
        }
        $newlist = new lists\ArrayList();
        $newlist->addAll($list->subList(0, $from));
        foreach ($ar as $val) {
            $newlist->add($val);
        }
        $newlist->addAll($list->subList($to, $size - 1, true, true));
        $list = $newlist;
    }

    private static function cmpObjects($a, $b) {
        $ret = $a->compareTo($b);
        if($ret === 0){
                return 0;
            }
            if($ret>0){
                return 1;
            }
            if($ret<0){
                return -1;
            }
    }

    /**
     * Swaps the element from posA with posB
     */
    public static function swap(ListI $list, $posA, $posB) {
        if($posA>=0&&$posA<$list->count()&&$posB>=0&&$posB<$list->count()){
            $h = $list->set($posA, $list->get($posB));
            $list->set($posB, $h);
        }
        else
            throw new \blaze\lang\IndexOutOfBoundsException ('posA: '.$posA.'posB:'.$posB.'size:'.$list->count());
    }

    /**
     * Returns true if the two arrays are deeply equal
     * @return boolean
     */
    public static function deepEquals(arrays\ArrayObject $a1, arrays\ArrayObject $a2) {
       
    }

    /**
     * Returns a bounded Collection and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Collection
     * @return blaze\collection\Collection
     */
    public static function boundedCollection(Collection $obj, $maxSize) {
        return new collection\BoundedCollection($obj, $maxSize);
    }

    /**
     * Returns a bounded SortedCollection and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedCollection
     * @return blaze\collection\collection\SortedCollection
     */
    public static function boundedSortedCollection(\blaze\collections\collection\SortedCollection $obj, $maxSize) {
        return new collectio\BoundedSortedCollection($obj, $maxSize);
    }

    /**
     * Returns a bounded Bag and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Bag
     * @return blaze\collection\Bag
     */
    public static function boundedBag(Bag $obj, $maxSize) {
        return new bag\BoundedBag($obj, $maxSize);
    }

    /**
     * Returns a bounded SortedBag and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedBag
     * @return blaze\collection\bag\SortedBag
     */
    public static function boundedSortedBag(\blaze\collections\bag\SortedBag $obj, $maxSize) {
        return new bag\BoundedSortedBag($obj, $maxSize);
    }

    /**
     * Returns a bounded Set and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Set
     * @return blaze\collection\Set
     */
    public static function boundedSet(Set $obj, $maxSize) {
        return new set\BoundedSet($obj, $maxSize);
    }

    /**
     * Returns a bounded SortedSet and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedSet
     * @return blaze\collection\set\SortedSet
     */
    public static function boundedSortedSet(\blaze\collections\set\SortedSet $obj, $maxSize) {
        return new set\BoundedSortedSet($obj, $maxSize);
    }

    /**
     * Returns a bounded ListI and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the ListI
     * @return blaze\collection\ListI
     */
    public static function boundedList(\blaze\collections\ListI $obj, $maxSize) {
        return new lists\BoundedList($obj, $maxSize);
    }

    /**
     * Returns a bounded Map and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the Map
     * @return blaze\collection\Map
     */
    public static function boundedMap(Map $obj, $maxSize) {
        return new map\BoundedMap($obj, $maxSize);
    }

    /**
     * Returns a bounded SortedMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedMap
     * @return blaze\collection\map\SortedMap
     */
    public static function boundedSortedMap(\blaze\collections\map\SortedMap $obj, $maxSize) {
        return new map\BoundedSortedMap($obj, $maxSize);
    }

    /**
     * Returns a bounded BidiMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the BidiMap
     * @return blaze\collection\BidiMap
     */
    public static function boundedBidiMap(BidiMap $obj, $maxSize) {
        return new bidimap\BoundedBidiMap($obj, $maxSize);
    }

    /**
     * Returns a bounded SortedBidiMap and cuts of the elements which are to much
     * @param int $maxSize the maximum size of the SortedBidiMap
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function boundedSortedBidiMap(\blaze\collections\bidimap\SortedBidiMap $obj, $maxSize) {
        return new bidimap\BoundedSortedBidiMap($obj, $maxSize);
    }

    /**
     * Returns an immutable Collection and cuts of the elements which are to much
     * @return blaze\collection\Collection
     */
    public static function immutableCollection(Collection $obj) {
        return new collection\ImmutableCollection($obj);
    }

    /**
     * Returns an immutable SortedCollection and cuts of the elements which are to much
     * @return blaze\collection\collection\SortedCollection
     */
    public static function immutableSortedCollection(\blaze\collections\collection\SortedCollection $obj) {
        return new collection\ImmutableSortedCollection($obj);
    }

    /**
     * Returns an immutable Bag and cuts of the elements which are to much
     * @return blaze\collection\Bag
     */
    public static function immutableBag(Bag $obj) {
        return new bag\ImmutableBag($obj);
    }

    /**
     * Returns an immutable SortedBag and cuts of the elements which are to much
     * @return blaze\collection\bag\SortedBag
     */
    public static function immutableSortedBag(\blaze\collections\bag\SortedBag $obj) {
        return new bag\ImmutableSortedBag($obj);
    }

    /**
     * Returns an immutable Set and cuts of the elements which are to much
     * @return blaze\collection\Set
     */
    public static function immutableSet(Set $obj) {
        return new set\ImmutableSet($obj);
    }

    /**
     * Returns an immutable SortedSet and cuts of the elements which are to much
     * @return blaze\collection\set\SortedSet
     */
    public static function immutableSortedSet(\blaze\collections\set\SortedSet $obj) {
        return new set\ImmutableSortedSet($obj);
    }

    /**
     * Returns an immutable SortedBidiMap and cuts of the elements which are to much
     * @return blaze\collection\ListI
     */
    public static function immutableList(\blaze\collections\ListI $obj) {
        return new lists\ImmutableList($obj);
    }

    /**
     * Returns an immutable Map and cuts of the elements which are to much
     * @return blaze\collection\Map
     */
    public static function immutableMap(Map $obj) {
        return new map\ImmutableMap($obj);
    }

    /**
     * Returns an immutable SortedMap and cuts of the elements which are to much
     * @return blaze\collection\map\SortedMap
     */
    public static function immutableSortedMap(\blaze\collections\map\SortedMap $obj) {
        return new map\ImmutableSortedMap($obj);
    }

    /**
     * Returns an immutable BidiMap and cuts of the elements which are to much
     * @return blaze\collection\BidiMap
     */
    public static function immutableBidiMap(BidiMap $obj) {
        return new bidimap\ImmutableBidiMap($obj);
    }

    /**
     * Returns an immutable SortedBidiMap and cuts of the elements which are to much
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function immutableSortedBidiMap(\blaze\collections\bidimap\SortedBidiMap $obj) {
        return new bidimap\ImmutableSortedBidiMap($obj);
    }

    /**
     * Returns a typed Collection and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Collection
     */
    public static function typedCollection(Collection $obj, $type) {
        return new collection\TypedCollection($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed SortedCollection and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\collection\SortedCollection
     */
    public static function typedSortedCollection(\blaze\collections\collection\SortedCollection $obj, $type) {
        return new collection\TypedSortedCollection($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed Bag and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Bag
     */
    public static function typedBag(Bag $obj, $type) {
        return new bag\TypedBag($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed SortedBag and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\bag\SortedBag
     */
    public static function typedSortedBag(\blaze\collections\bag\SortedBag $obj, $type) {
        return new bag\TypedSortedBag($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed Set and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Set
     */
    public static function typedSet(Set $obj, $type) {
        return new set\TypedSet($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed SortedSet and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\set\SortedSet
     */
    public static function typedSortedSet(\blaze\collections\set\SortedSet $obj, $type) {
        return new set\TypedSortedSet($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed SortedBidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\ListI
     */
    public static function typedList(\blaze\collections\ListI $obj, $type) {
        return new lists\TypedList($obj, TypeChecker::getInstance($type));
    }

    /**
     * Returns a typed Map and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\Map
     */
    public static function typedMap(Map $obj, $keyType, $valueType) {
        return new map\TypedMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }

    /**
     * Returns a typed SortedMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\map\SortedMap
     */
    public static function typedSortedMap(\blaze\collections\map\SortedMap $obj, $keyType, $valueType) {
        return new map\TypedSortedMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }

    /**
     * Returns a typed BidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\BidiMap
     */
    public static function typedBidiMap(BidiMap $obj, $keyType, $valueType) {
        return new bidimap\TypedBidiMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }

    /**
     * Returns a typed SortedBidiMap and cuts of the elements which are to much
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collection\bidimap\SortedBidiMap
     */
    public static function typedSortedBidiMap(\blaze\collections\bidimap\SortedBidiMap $obj, $keyType, $valueType) {
        return new bidimap\TypedSortedBidiMap($obj, TypeChecker::getInstance($keyType), TypeChecker::getInstance($valueType));
    }

}

?>
