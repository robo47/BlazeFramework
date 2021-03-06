<?php

namespace blaze\collections\map;

/**
 * This is a basic implementation of a SortedMagDecorator which can be used to
 * give a SortedMag a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSortedMapDecorator extends AbstractMapDecorator implements \blaze\collections\map\SortedMap {

    /**
     * The decorated map.
     * @var \blaze\collections\map\SortedMap
     */
    protected $sortedMap;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\map\SortedMap $map The decorated map.
     */
    public function __construct(\blaze\collections\map\SortedMap $map) {
        parent::__construct($map);
        $this->sortedMap = $map;
    }

    public function ceiling(\blaze\lang\Reflectable $element) {
        return $this->sortedMap->ceiling($element);
    }

    public function ceilingEntry(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->ceilingEntry($key);
    }

    public function ceilingKey(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->ceilingKey($key);
    }

    public function comparator() {
        return $this->sortedMap->comparator();
    }

    public function descendingIterator() {
        return $this->sortedMap->descendingIterator();
    }

    public function descendingKeySet() {
        return $this->sortedMap->descendingKeySet();
    }

    public function descendingMap() {
        return $this->sortedMap->descendingMap();
    }

    public function first() {
        return $this->sortedMap->first();
    }

    public function firstEntry() {
        return $this->sortedMap->firstEntry();
    }

    public function firstKey() {
        return $this->sortedMap->firstKey();
    }

    public function floor(\blaze\lang\Reflectable $element) {
        return $this->sortedMap->floor($element);
    }

    public function floorEntry(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->floorEntry($key);
    }

    public function floorKey(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->floorKey($key);
    }

    public function headMap(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        return $this->sortedMap->headMap($toElement, $inclusive);
    }

    public function higher(\blaze\lang\Reflectable $element) {
        return $this->sortedMap->higher($element);
    }

    public function higherEntry(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->higherEntry($key);
    }

    public function higherKey(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->higherKey($key);
    }

    public function last() {
        return $this->sortedMap->last();
    }

    public function lastEntry() {
        return $this->sortedMap->lastEntry();
    }

    public function lastKey() {
        return $this->sortedMap->lastKey();
    }

    public function lower(\blaze\lang\Reflectable $element) {
        return $this->sortedMap->lower($element);
    }

    public function lowerEntry(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->lowerEntry($key);
    }

    public function lowerKey(\blaze\lang\Reflectable $key) {
        return $this->sortedMap->lowerKey($key);
    }

    public function pollFirst() {
        return $this->sortedMap->pollFirst();
    }

    public function pollFirstEntry() {
        return $this->sortedMap->pollFirstEntry();
    }

    public function pollLast() {
        return $this->sortedMap->pollLast();
    }

    public function pollLastEntry() {
        return $this->sortedMap->pollLastEntry();
    }

    public function subMap(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->sortedMap->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailMap(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        return $this->sortedMap->tailMap($fromElement, $inclusive);
    }

}

?>
