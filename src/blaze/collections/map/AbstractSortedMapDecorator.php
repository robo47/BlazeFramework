<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractSortedMapDecorator extends AbstractMapDecorator implements \blaze\collections\map\SortedMap {
    
    public function __construct(\blaze\collections\map\SortedMap $map) {
        parent::__construct($map);
    }
    
    public function ceiling($element) {
        return $this->map->ceiling($element);
    }

    public function ceilingEntry($key) {
        return $this->map->ceilingEntry($key);
    }

    public function ceilingKey($key) {
        return $this->map->ceilingKey($key);
    }

    public function comparator() {
        return $this->map->comparator();
    }

    public function descendingIterator() {
        return $this->map->descendingIterator();
    }

    public function descendingKeySet() {
        return $this->map->descendingKeySet();
    }

    public function descendingMap() {
        return $this->map->descendingMap();
    }

    public function first() {
        return $this->map->first();
    }

    public function firstEntry() {
        return $this->map->firstEntry();
    }

    public function firstKey() {
        return $this->map->firstKey();
    }

    public function floor($element) {
        return $this->map->floor($element);
    }

    public function floorEntry($key) {
        return $this->map->floorEntry($key);
    }

    public function floorKey($key) {
        return $this->map->floorKey($key);
    }

    public function headMap($toElement, $inclusive = true) {
        return $this->map->headMap($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->map->higher($element);
    }

    public function higherEntry($key) {
        return $this->map->higherEntry($key);
    }

    public function higherKey($key) {
        return $this->map->higherKey($key);
    }

    public function last() {
        return $this->map->last();
    }

    public function lastEntry() {
        return $this->map->lastEntry();
    }

    public function lastKey() {
        return $this->map->lastKey();
    }

    public function lower($element) {
        return $this->map->lower($element);
    }

    public function lowerEntry($key) {
        return $this->map->lowerEntry($key);
    }

    public function lowerKey($key) {
        return $this->map->lowerKey($key);
    }

    public function pollFirst() {
        return $this->map->pollFirst();
    }

    public function pollFirstEntry() {
        return $this->map->pollFirstEntry();
    }

    public function pollLast() {
        return $this->map->pollLast();
    }

    public function pollLastEntry() {
        return $this->map->pollLastEntry();
    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->map->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailMap($fromElement, $inclusive = true) {
        return $this->map->tailMap($fromElement, $inclusive);
    }

}

?>
