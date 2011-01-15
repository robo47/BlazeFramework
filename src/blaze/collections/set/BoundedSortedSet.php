<?php

namespace blaze\collections\set;

/**
 * A sorted set decorator which specifies bounds for a sorted set
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedSortedSet extends AbstractSortedSetDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the sorted set
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a sorted set which is bounded.
     *
     * @param \blaze\collections\set\SortedSet $set The decorated sorted set
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\set\SortedSet $set, $maxCount) {
        parent::__construct($set);
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
     * When the sorted set is full nothing is added and false is returned.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        if (!$this->isFull())
            return $this->set->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the sorted set has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->set->addAll($obj);
        else
            return false;
    }

}

?>
