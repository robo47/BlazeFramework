<?php

namespace blaze\collections\bag;

/**
 * A bag decorator which specifies bounds for a sorted bag.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedSortedBag extends AbstractSortedBagDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the bag
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a sorted bag which is bounded.
     *
     * @param \blaze\collections\bag\SortedBag $bag The decorated bag
     * @param int $maxCount The maximal size
     */
    public function __construct(SortedBag $bag, $maxCount) {
        parent::__construct($bag);
        $this->maxCount = $maxCount;
    }

    /**
     * {@inheritDoc}
     * When the sorted bag is full nothing is added and false is returned.
     */
    public function add($obj) {
        if (!$this->isFull())
            return $this->bag->add($obj);
    }

    /**
     * {@inheritDoc}
     * When the sorted bag has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->bag->addAll($obj);
    }

    /**
     * {@inheritDoc}
     * When the sorted bag is full and the object is not contained by the banothing is added and false is returned.
     */
    public function addCount($obj, $count) {
        if (!$this->contains($obj)) {
            if (!$this->isFull())
                return $this->bag->addCount($obj, $count);
            else
                return false;
        }else {
            return $this->bag->addCount($obj, $count);
        }
    }

    public function isFull() {
        return $this->bag->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

}

?>
