<?php

namespace blaze\collections\collection;

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
final class BoundedCollection implements \blaze\collections\Collection, \blaze\collections\Bounded {
    private $collection;
    private $maxCount;

    public function __construct(\blaze\collections\Collection $collection, $maxCount) {
        $this->collection = $collection;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function clear() {

    }

    public function contains($obj) {

    }

    public function containsAll(Collection $c) {

    }

    public function count() {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function maxCount() {

    }

    public function remove($obj) {

    }

    public function removeAll(Collection $obj) {

    }

    public function retainAll(Collection $obj) {

    }

    public function toArray($type = null) {

    }

}

?>
