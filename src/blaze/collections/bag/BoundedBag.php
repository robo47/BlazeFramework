<?php

namespace blaze\collections\bag;

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
final class BoundedBag implements \blaze\collections\Bag, \blaze\collections\Bounded {

    private $bag;
    private $maxCount;

    public function __construct(\blaze\collections\Bag $bag, $maxCount) {
        $this->bag = $bag;
        $this->maxCount = $maxCount;
    }

    public function add($obj) {

    }

    public function addAll(Collection $obj) {

    }

    public function addCount($obj, $count) {

    }

    public function clear() {

    }

    public function contains($obj) {

    }

    public function containsAll(Collection $c) {

    }

    public function count() {

    }

    public function getCount($obj) {

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

    public function removeCount($obj, $count) {

    }

    public function retainAll(Collection $obj) {

    }

    public function toArray($type = null) {

    }

    public function uniqueSet() {

    }

}

?>
