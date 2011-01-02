<?php

namespace blaze\collections\collection;

/**
 * This is a basic implementation of a SortedCollectionDecorator which can be used to
 * give a SortedCollection a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedCollectionDecorator extends AbstractCollectionDecorator implements \blaze\collections\collection\SortedCollection {

    /**
     * The decorated collection.
     * @var \blaze\collections\SortedCollection
     */
    protected $sortedCollection;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\SortedCollection $collection The decorated collection.
     */
    public function __construct(\blaze\collections\SortedCollection $collection) {
        parent::__construct($collection);
        $this->sortedCollection = $collection;
    }

    public function ceiling($element) {
        return $this->sortedCollection->ceiling($element);
    }

    public function comparator() {
        return $this->sortedCollection->comparator();
    }

    public function descendingCollection() {
        return $this->sortedCollection->descendingCollection();
    }

    public function descendingIterator() {
        return $this->sortedCollection->descendingIterator();
    }

    public function first() {
        return $this->sortedCollection->first();
    }

    public function floor($element) {
        return $this->sortedCollection->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->sortedCollection->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->sortedCollection->higher($element);
    }

    public function last() {
        return $this->sortedCollection->last();
    }

    public function lower($element) {
        return $this->sortedCollection->lower($element);
    }

    public function pollFirst() {
        return $this->sortedCollection->pollFirst();
    }

    public function pollLast() {
        return $this->sortedCollection->pollLast();
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedCollection->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->sortedCollection->tailCollection($fromElement, $inclusive);
    }

}

?>
