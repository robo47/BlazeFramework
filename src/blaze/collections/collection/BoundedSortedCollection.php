<?php

namespace blaze\collections\collection;

/**
 * A sorted collection decorator which specifies bounds for a sortedcollection
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedSortedCollection extends AbstractSortedCollectionDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the collection
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a sorted collection which is bounded.
     *
     * @param \blaze\collections\Collection $collection The decorated collection
     * @param int $maxCount The maximal size
     */
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

    /**
     * {@inheritDoc}
     * When the collection is full nothing is added and false is returned.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        if (!$this->isFull())
            return $this->collection->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the sorted collection has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->collection->addAll($obj);
        else
            return false;
    }

}

?>
