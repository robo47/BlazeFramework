<?php

namespace blaze\collections;

/**
 * This class offers static methods for operating with arrays. For operations
 * with collections see below.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     \blaze\collections\Collections
 * @since   1.0
 */
class Arrays extends \blaze\lang\Object {

    private function __construct() {

    }

    /**
     * Returns a fixed size ListI based on the content of the give array
     *
     * @param array|\blaze\collections\ArrayI $array The contents of the array which should be used as content for the list
     * @return blaze\collections\ListI An immutable list with the contents of the array.
     */
    public static function asList($array) {
        return Collections::immutableList(new lists\ArrayList($array));
    }

    /**
     * Looks for a key in the array and returns the index of it.
     * Checks wether the array is typed or not. If it is not typed, then the
     * array has to be converted into one. The comparator can only be used for
     * arrays which manage objects.
     *
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @param mixed $key The key which shall be looked for
     * @param \blaze\lang\Comparator $c The comparator which is used to compare the elements of the array
     * @return int Returns the index of the array on which the key can be found as positive integer or as negative integer to specify that the key would be expected at that index.
     * @throws blaze\lang\IndexOutOfBoundsException
     */
    public static function binarySearch($a, $key, \blaze\lang\Comparator $c = null) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        return self::binaryRangeSearch($a, $key, 0, $a->count(), $c);
    }

    /**
     * This method is the same as binarySearch with the exception that a range
     * can be given in which shall be searched for the key.
     *
     * @param array|\blaze\collections\ArrayI $a
     * @param mixed $key
     * @param int $fromIndex The index where to start at in the array
     * @param int $toIndex The index where to stop at in the array
     * @param blaze\lang\Comparator $c
     * @return int
     * @throws blaze\lang\IndexOutOfBoundsException
     */
    public static function binaryRangeSearch($a, $key, $fromIndex, $toIndex, \blaze\lang\Comparator $c = null) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        if($a->count() == 0)
                return 0;
        $comparator = true;

        if ($c == null) {
            $value = $a[0];

            if(is_string($value))
                return \array_search($key, $a);
            else if(is_float($value))
                return \array_search($key, $a);
            else if(is_int($value))
                return \array_search($key, $a);
            else if(is_bool($value))
                return \array_search($key, $a);
            else if($value instanceof \blaze\lang\Comparable)
                $comparator = false;

            throw new IllegalArgumentException('No valid element types!');
	}

	$low = $fromIndex;
	$high = $toIndex - 1;

	while ($low <= $high) {
	    $mid = ($low + $high) >> 1;
	    $midVal = $a[$mid];

            if($comparator)
                $cmp = $c->compare($midVal, $key);
            else
                $cmp = $key->compareTo($midVal);
            
	    if ($cmp < 0)
		$low = $mid + 1;
	    else if ($cmp > 0)
		$high = $mid - 1;
	    else
		return $mid; // key found
	}
	return -($low + 1);  // key not found.
    }

    /**
     * Copies the array into a new one with newLength and adds/turncate values.
     *
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return blaze\collections\ArrayI
     */
    public static function copyOf($a, $newLength) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        $newA = new arrays\ArrayObject($newLength);
        $count = $newLength > $a->count() ? $a->count() : $newLength;

        for($i = 0; $i < $count; $i++)
            $newA[$i] = $a[$i];
        return $newA;
    }

    /**
     * Copies a subpart of the array into a new one
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return blaze\collections\ArrayI
     */
    public static function copyOfRange($a, $from, $to) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        $newA = new arrays\ArrayObject($to - $from);

        for($i = $from; $i < $to; $i++)
            $newA[$i] = $a[$i];
        return $newA;
    }

    /**
     * Assigns value to every element of the array
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     */
    public static function fill($a, $value) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        return new \ArrayObject(array_fill(0, $a->count(), $value));
    }

    /**
     * Assigns value to every element of the subpart of the array
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     */
    public static function fillRange($a, $from, $to, $value) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        if($a->count() > $to)
                throw new \blaze\lang\IndexOutOfBoundsException($to);
        if($from < 0)
                throw new \blaze\lang\IndexOutOfBoundsException($from);
        return new \ArrayObject(array_fill($from, $to, $value));
    }

    /**
     * Sorts the array.
     * The comparator can only be used for arrays which manage objects.
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     */
    public static function sort($a, \blaze\lang\Comparator $c = null) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        if($a->count() == 0)
                return;

        if ($c == null) {
            $value = $a[0];

            if(is_string($value) || is_float($value) || is_int($value) || is_bool($value))
                sort($a);
            else if($value instanceof \blaze\lang\Comparable)
                usort($a,array('\\blaze\\collections\\ComparableComparator','compare'));

            throw new IllegalArgumentException('No valid element types!');
	}else{
            usort($a,array($c,'compare'));
        }
    }

    /**
     * Same as sort but for a specific range.
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     */
    public static function sortRange($a, $from, $to, \blaze\lang\Comparator $c = null) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns true if the two arrays are deeply equal
     * @param array|\blaze\collections\ArrayI $a1 The array in which to look for the key
     * @param array|\blaze\collections\ArrayI $a2 The array in which to look for the key
     * @return boolean
     */
    public static function deepEquals($a1, $a2) {
        if(!is_array($a1) && !$a1 instanceof ArrayI && !is_array($a2) && !$a2 instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns a hash code based on the deep contents
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return int
     */
    public static function deepHashCode($a) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns the string representation of the deep contents
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return blaze\lang\String
     */
    public static function deepToString($a) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns wether the contents of both arrays are equal or not.
     * @param array|\blaze\collections\ArrayI $a1 The array in which to look for the key
     * @param array|\blaze\collections\ArrayI $a2 The array in which to look for the key
     * @return boolean
     */
    public static function flatEquals($a1, $a2) {
        if(!is_array($a1) && !$a1 instanceof ArrayI && !is_array($a2) && !$a2 instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns the hashcodes based on the contents
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return int
     */
    public static function flatHashCode($a) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns a string representation based on the contents
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return blaze\lang\String
     */
    public static function flatToString($a) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        
    }

    /**
     * Returns a immutable ArrayI
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @return blaze\collections\ArrayI
     */
    public static function immutableArray($a) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        return new arrays\ImmutableArray($a);
    }

    /**
     * Returns a typed ArrayI
     * @param array|\blaze\collections\ArrayI $a The array in which to look for the key
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collections\ArrayI
     */
    public static function typedArray($a, $type) {
        if(!is_array($a) && !$a instanceof ArrayI)
            throw new \blaze\lang\ClassCastException('No array given');
        return new arrays\TypedArray($a, TypeChecker::getInstance($type));
    }

}

class ComparableComparator{
    public static function compare(\blaze\lang\Object $o1, \blaze\lang\Object $o2){
        if($o1 !== null && $o1 instanceof \blaze\lang\Comparable)
            return $o1->compareTo($o2);
        throw new \blaze\lang\ClassCastException($o1.' is not Comparable');
    }

}

?>
