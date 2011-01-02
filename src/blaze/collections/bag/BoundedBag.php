<?php

namespace blaze\collections\bag;

/**
 * A bag decorator which specifies bounds for a bag.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedBag extends AbstractBagDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the bag
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a bag which is bounded.
     *
     * @param \blaze\collections\Bag $bag The decorated bag
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\Bag $bag, $maxCount) {
        parent::__construct($bag);
        $this->maxCount = $maxCount;
    }

    /**
     * {@inheritDoc}
     * When the bag is full nothing is added and false is returned.
     */
    public function add($obj) {
        if (!$this->isFull())
            return $this->bag->add($obj);
        return false;
    }

    /**
     * {@inheritDoc}
     * When the bag has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->bag->addAll($obj);
        return false;
    }

    /**
     * {@inheritDoc}
     * When the bag is full and the object is not contained by the banothing is added and false is returned.
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
        return $this->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

}

?>
