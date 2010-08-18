<?php
namespace blaze\collections;

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
     * Copies the array into a new one with newLength and adds/turncate values.
     * @return blaze\collections\ArrayObject
     */
    public static function copyOf(ArrayObject $a, $newLength){}
    /**
     * Copies a subpart of the array into a new one
     * @return blaze\collections\ArrayObject
     */
    public static function copyOfRange(ArrayObject $a, $from, $to){}
    /**
     * Assigns value to every element of the array
     */
    public static function fill(ArrayObject $a, $value){}
    /**
     * Assigns value to every element of the subpart of the array
     */
    public static function fillRange(ArrayObject $a, $from, $to, $value){}
    /**
     * Sorts the array.
     * The comparator can only be used for arrays which manage objects.
     */
    public static function sort(ArrayObject $a, \blaze\lang\Comparator $c = null){}
    /**
     * Same as sort but for a specific range.
     */
    public static function sortRange(ArrayObject $a, $from, $to, \blaze\lang\Comparator $c = null){}
    /**
     * Returns true if the two arrays are deeply equal
     * @return boolean
     */
    public static function deepEquals(ArrayObject $a1, ArrayObject $a2){}
    /**
     * Returns a hash code based on the deep contents
     * @return int
     */
    public static function deepHashCode(ArrayObject $a1){}
    /**
     * Returns the string representation of the deep contents
     * @return blaze\lang\String
     */
    public static function deepToString(ArrayObject $a1){}
    /**
     * @return boolean
     */
    public static function flatEquals(ArrayObject $a1, ArrayObject $a2){}
    /**
     * Returns the hashcodes based on the contents
     * @return int
     */
    public static function flatHashCode(ArrayObject $a){}
    /**
     * Returns a string representation based on the contents
     * @return blaze\lang\String
     */
    public static function flatToString(ArrayObject $a){}
}

?>
