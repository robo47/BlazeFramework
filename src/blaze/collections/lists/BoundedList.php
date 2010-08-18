<?php

namespace blaze\collections\lists;

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
final class BoundedList implements \blaze\collections\ListI, \blaze\collections\Bounded {

    private $list;
    private $maxCount;

    public function __construct(\blaze\collections\ListI $list, $maxCount) {
        $this->list = $list;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function addAllAt($index, Collection $c) {

    }

    public function addAt($index, $obj) {

    }

    public function clear() {

    }

    public function contains($obj) {

    }

    public function containsAll(Collection $c) {

    }

    public function count() {

    }

    public function get($index) {

    }

    public function indexOf($obj) {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function lastIndexOf($obj) {

    }

    public function listIterator($index = 0) {

    }

    public function maxCount() {

    }

    public function remove($obj) {

    }

    public function removeAll(Collection $obj) {

    }

    public function removeAt($index) {

    }

    public function retainAll(Collection $obj) {

    }

    public function set($index, $obj) {

    }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {

    }

    public function toArray($type = null) {

    }

    
}

?>
