<?php

namespace blaze\collections\bidimap;

/**
 * This is a basic implementation of a SortedBidiMapDecorator which can be used to
 * give a SortedBidiMap a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedBidiMapDecorator extends AbstractBidiMapDecorator implements \blaze\collections\bidimap\SortedBidiMap {

    /**
     * The decorated bidimap.
     * @var \blaze\collections\bidimap\SortedBidiMap
     */
    protected $sortedBidiMap;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\bidimap\SortedBidiMap $bidiMap The decorated bidimap.
     */
    public function __construct(\blaze\collections\bidimap\SortedBidiMap $bidiMap) {
        parent::__construct($bidiMap);
        $this->sortedBidiMap = $bidiMap;
    }

    public function ceiling($element) {
        return $this->sortedBidiMap->ceiling($element);
    }

    public function ceilingEntry($key) {
        return $this->sortedBidiMap->ceilingEntry($key);
    }

    public function ceilingKey($key) {
        return $this->sortedBidiMap->ceilingKey($key);
    }

    public function comparator() {
        return $this->sortedBidiMap->comparator();
    }

    public function descendingIterator() {
        return $this->sortedBidiMap->descendingIterator();
    }

    public function descendingKeySet() {
        return $this->sortedBidiMap->descendingKeySet();
    }

    public function descendingMap() {
        return $this->sortedBidiMap->descendingMap();
    }

    public function first() {
        return $this->sortedBidiMap->first();
    }

    public function firstEntry() {
        return $this->sortedBidiMap->firstEntry();
    }

    public function firstKey() {
        return $this->sortedBidiMap->firstKey();
    }

    public function floor($element) {
        return $this->sortedBidiMap->floor($element);
    }

    public function floorEntry($key) {
        return $this->sortedBidiMap->floorEntry($key);
    }

    public function floorKey($key) {
        return $this->sortedBidiMap->floorKey($key);
    }

    public function headMap($toElement, $inclusive = true) {
        return $this->sortedBidiMap->headMap($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->sortedBidiMap->higher($element);
    }

    public function higherEntry($key) {
        return $this->sortedBidiMap->higherEntry($key);
    }

    public function higherKey($key) {
        return $this->sortedBidiMap->higherKey($key);
    }

    public function last() {
        return $this->sortedBidiMap->last();
    }

    public function lastEntry() {
        return $this->sortedBidiMap->lastEntry();
    }

    public function lastKey() {
        return $this->sortedBidiMap->lastKey();
    }

    public function lower($element) {
        return $this->sortedBidiMap->lower($element);
    }

    public function lowerEntry($key) {
        return $this->sortedBidiMap->lowerEntry($key);
    }

    public function lowerKey($key) {
        return $this->sortedBidiMap->lowerKey($key);
    }

    public function pollFirst() {
        return $this->sortedBidiMap->pollFirst();
    }

    public function pollFirstEntry() {
        return $this->sortedBidiMap->pollFirstEntry();
    }

    public function pollLast() {
        return $this->sortedBidiMap->pollLast();
    }

    public function pollLastEntry() {
        return $this->sortedBidiMap->pollLastEntry();
    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedBidiMap->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailMap($fromElement, $inclusive = true) {
        return $this->sortedBidiMap->tailMap($fromElement, $inclusive);
    }

}

?>
