<?php

namespace blaze\collections\bag;

/**
 * This is a basic implementation of a SortedBagDecorator which can be used to
 * give a SortedBag a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedBagDecorator extends AbstractBagDecorator implements \blaze\collections\bag\SortedBag {

    /**
     * The decorated bag.
     * @var \blaze\collections\bag\SortedBag
     */
    protected $sortedBag;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\bag\SortedBag $bag The decorated bag.
     */
    public function __construct(\blaze\collections\bag\SortedBag $bag) {
        parent::__construct($bag);
        $this->sortedBag = $bag;
    }

    public function ceiling($element) {
        return $this->sortedBag->ceiling($element);
    }

    public function comparator() {
        return $this->sortedBag->comparator();
    }

    public function descendingBag() {
        return $this->sortedBag->descendingBag();
    }

    public function descendingCollection() {
        return $this->sortedBag->descendingCollection();
    }

    public function descendingIterator() {
        return $this->sortedBag->descendingIterator();
    }

    public function first() {
        return $this->sortedBag->first();
    }

    public function floor($element) {
        return $this->sortedBag->floor($element);
    }

    public function headBag($toElement, $inclusive = true) {
        return $this->sortedBag->headBag($toElement, $inclusive);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->sortedBag->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->sortedBag->higher($element);
    }

    public function last() {
        return $this->sortedBag->last();
    }

    public function lower($element) {
        return $this->sortedBag->lower($element);
    }

    public function pollFirst() {
        return $this->sortedBag->pollFirst();
    }

    public function pollLast() {
        return $this->sortedBag->pollLast();
    }

    public function subBag($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedBag->subBag($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedBag->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailBag($fromElement, $inclusive = true) {
        return $this->sortedBag->tailBag($fromElement, $inclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->sortedBag->tailCollection($fromElement, $inclusive);
    }

}

?>
