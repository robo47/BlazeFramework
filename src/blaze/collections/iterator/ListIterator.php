<?php
namespace blaze\collections\iterator;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface ListIterator extends \blaze\collections\Iterator{
    /**
     * Inserts the specified element into the list (optional operation).
     */
    public function add($value);
    /**
     * Returns true if this list iterator has more elements when traversing the list in the reverse direction.
     * @return boolean
     */
    public function hasPrevious();
    /**
     * Returns the index of the element that would be returned by a subsequent call to next.
     * @return int
     */
    public function nextIndex();
    /**
     * Returns the index of the element that would be returned by a subsequent call to previous.
     * @return mixed
     */
    public function previousIndex();
    /**
     * Returns the previous element in the list.
     * @return int
     */
    public function previous();
    /**
     * Replaces the last element returned by next or previous with the specified element (optional operation).
     * @return mixed
     */
    public function set($value);
}

?>
