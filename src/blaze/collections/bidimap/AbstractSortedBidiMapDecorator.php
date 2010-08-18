<?php

namespace blaze\collections\bidimap;

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
abstract class AbstractSortedBidiMapDecorator extends AbstractBidiMapDecorator implements \blaze\collections\bidimap\SortedBidiMap {
    
    public function __construct(\blaze\collections\bidimap\SortedBidiMap $bidiMap) {
        parent::__construct($bidiMap);
    }
    
    public function ceiling($element) {
        return $this->bidiMap->ceiling($element);
    }

    public function ceilingEntry($key) {
        return $this->bidiMap->ceilingEntry($key);
    }

    public function ceilingKey($key) {
        return $this->bidiMap->ceilingKey($key);
    }

    public function comparator() {
        return $this->bidiMap->comparator();
    }

    public function descendingIterator() {
        return $this->bidiMap->descendingIterator();
    }

    public function descendingKeySet() {
        return $this->bidiMap->descendingKeySet();
    }

    public function descendingMap() {
        return $this->bidiMap->descendingMap();
    }

    public function first() {
        return $this->bidiMap->first();
    }

    public function firstEntry() {
        return $this->bidiMap->firstEntry();
    }

    public function firstKey() {
        return $this->bidiMap->firstKey();
    }

    public function floor($element) {
        return $this->bidiMap->floor($element);
    }

    public function floorEntry($key) {
        return $this->bidiMap->floorEntry($key);
    }

    public function floorKey($key) {
        return $this->bidiMap->floorKey($key);
    }

    public function headMap($toElement, $inclusive = true) {
        return $this->bidiMap->headMap($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->bidiMap->higher($element);
    }

    public function higherEntry($key) {
        return $this->bidiMap->higherEntry($key);
    }

    public function higherKey($key) {
        return $this->bidiMap->higherKey($key);
    }

    public function last() {
        return $this->bidiMap->last();
    }

    public function lastEntry() {
        return $this->bidiMap->lastEntry();
    }

    public function lastKey() {
        return $this->bidiMap->lastKey();
    }

    public function lower($element) {
        return $this->bidiMap->lower($element);
    }

    public function lowerEntry($key) {
        return $this->bidiMap->lowerEntry($key);
    }

    public function lowerKey($key) {
        return $this->bidiMap->lowerKey($key);
    }

    public function pollFirst() {
        return $this->bidiMap->pollFirst();
    }

    public function pollFirstEntry() {
        return $this->bidiMap->pollFirstEntry();
    }

    public function pollLast() {
        return $this->bidiMap->pollLast();
    }

    public function pollLastEntry() {
        return $this->bidiMap->pollLastEntry();
    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->bidiMap->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailMap($fromElement, $inclusive = true) {
        return $this->bidiMap->tailMap($fromElement, $inclusive);
    }

}

?>
