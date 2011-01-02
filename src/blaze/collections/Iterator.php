<?php
namespace blaze\collections;

/**
 * This is just to provide a framework specific interface in the case that
 * php will use a different namespace for the SPL stuff in further versions.
 * Furthermore it provides methods to give a java feeling for iteration.
 * A simple iteration will look like:
 *
 * $iterator = ...
 * while($iterator->hasNext()){
 *  $obj = $iterator->next();
 *  ...
 * }
 *
 * The methods which are needed for using and Iterable object in a forech-loop
 * have to be implemented right, but it is also necessary to support the way
 * this iterator has to work. The best example of how to implement an iterator can
 * be found in \blaze\collections\lists\ArrayList in this class is another class
 * named ArrayListIterator which has private access and does not appear in documentation.
 * It is hidden in there because PHP does not support inner classes.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     \blaze\collections\Iterable
 * @since   1.0
 */
interface Iterator extends \Iterator{
    /**
     * Returns if another object can be iterated, this method has to block until
     * a right value can be returned.
     * @return boolean true if there is another object, otherwise false
     */
    public function hasNext();
    /**
     * Removes the current object
     */
    public function remove();
}

?>
