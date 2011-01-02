<?php

namespace blaze\collections\set;

/**
 * This is a basic implementation of a SortedSetDecorator which can be used to
 * give a SortedSet a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedSetDecorator extends AbstractSetDecorator implements \blaze\collections\set\SortedSet {

    /**
     * The decorated set.
     * @var \blaze\collections\set\SortedSet
     */
    protected $sortedSet;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\set\SortedSet $set The decorated set.
     */
    public function __construct(\blaze\collections\set\SortedSet $set) {
        parent::__construct($set);
        $this->sortedSet = $set;
    }

    public function ceiling($element) {
        return $this->sortedSet->ceiling($element);
    }

    public function comparator() {
        return $this->sortedSet->comparator();
    }

    public function descendingCollection() {
        return $this->sortedSet->descendingCollection();
    }

    public function descendingIterator() {
        return $this->sortedSet->descendingIterator();
    }

    public function first() {
        return $this->sortedSet->first();
    }

    public function floor($element) {
        return $this->sortedSet->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->sortedSet->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->sortedSet->higher($element);
    }

    public function last() {
        return $this->sortedSet->last();
    }

    public function lower($element) {
        return $this->sortedSet->lower($element);
    }

    public function pollFirst() {
        return $this->sortedSet->pollFirst();
    }

    public function pollLast() {
        return $this->sortedSet->pollLast();
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedSet->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->sortedSet->tailCollection($fromElement, $inclusive);
    }

    public function descendingSet() {
        return $this->sortedSet->descendingSet();
    }

    public function headSet($toElement, $inclusive = true) {
        return $this->sortedSet->headSet($toElement, $inclusive);
    }

    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedSet->subSet($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailSet($fromElement, $inclusive = true) {
        return $this->sortedSet->tailSet($fromElement, $inclusive);
    }

}

?>
