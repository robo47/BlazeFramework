<?php

namespace blaze\collections\set;

/**
 * A set decorator which specifies bounds for a set
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedSet extends AbstractSetDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the set
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a set which is bounded.
     *
     * @param \blaze\collections\Set $set The decorated set
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\Set $set, $maxCount) {
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
     * When the set is full nothing is added and false is returned.
     */
    public function add($obj) {
        if (!$this->isFull())
            return $this->set->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the set has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->set->addAll($obj);
        else
            return false;
    }

}

?>
