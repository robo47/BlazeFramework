<?php

namespace blaze\collections\lists;

/**
 * A list decorator which specifies bounds for a list
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedList extends AbstractListDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the list
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a list which is bounded.
     *
     * @param \blaze\collections\ListI $list The decorated list
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\ListI $list, $maxCount) {
        parent::__construct($list);
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
     * When the list is full nothing is added and false is returned.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        if (!$this->isFull())
            return $this->list->add($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the list is full nothing is added and false is returned.
     */
    public function addAt(\int $index, \blaze\lang\Reflectable $obj) {
        if (!$this->isFull())
            return $this->list->addAt($index, $obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the list has not enough space for all object nothing is added and false is returned.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->list->addAll($obj);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the list has not enough space for all object nothing is added and false is returned.
     */
    public function addAllAt(\int $index, \blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->list->addAllAt($index, $c);
        else
            return false;
    }

}

?>
