<?php
namespace blaze\collections;

/**
 * Implementations of this interface iterate over MapEntrys. The iterator can
 * be used like a simple iterator or in the foreach-loop like:
 *
 * foreach($map as $key => $value){
 *  ...
 * }
 *
 * The methods which are needed for using and Iterable object in a forech-loop
 * have to be implemented right, but it is also necessary to support the way
 * this iterator has to work. The best example of how to implement an iterator can
 * be found in \blaze\collections\map\HashMap. In this class is another class
 * named HashMapIterator which has private access and does not appear in documentation.
 * It is hidden in there because PHP does not support inner classes.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0
 */
interface MapIterator extends Iterator{
    /**
     * Returns the key of the entry.
     * @return mixed
     */
    public function getKey();
    /**
     * Returns the value of the entry.
     * @return mixed
     */
    public function getValue();
    /**
     * Sets the value of the entry, by setting the value the map has to be affected.
     * @param mixed $value
     */
    public function setValue($value);
}

?>
