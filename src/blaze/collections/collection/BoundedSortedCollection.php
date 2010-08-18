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
final class BoundedSortedCollection extends AbstractSortedCollectionDecorator implements \blaze\collections\Bounded {

    private $maxCount;

    public function __construct(\blaze\collections\Collection $collection, $maxCount) {
        parent::__construct($collection);
        $this->maxCount = $maxCount;
    }

    public function isFull() {
        return $this->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

    public function add($obj) {
        if (!$this->isFull())
            return $this->collection->add($obj);
        else
            return false;
    }

    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->collection->addAll($obj);
        else
            return false;
    }

}

?>
