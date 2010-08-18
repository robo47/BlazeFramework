<?php

namespace blaze\collections\set;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractSortedSetDecorator extends AbstractSetDecorator implements \blaze\collections\set\SortedSet {

    public function __construct(\blaze\collections\set\SortedSet $set) {
        parent::__construct($set);
    }

    public function ceiling($element) {
        return $this->set->ceiling($element);
    }

    public function comparator() {
        return $this->set->comparator();
    }

    public function descendingCollection() {
        return $this->set->descendingCollection();
    }

    public function descendingIterator() {
        return $this->set->descendingIterator();
    }

    public function first() {
        return $this->set->first();
    }

    public function floor($element) {
        return $this->set->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->set->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->set->higher($element);
    }

    public function last() {
        return $this->set->last();
    }

    public function lower($element) {
        return $this->set->lower($element);
    }

    public function pollFirst() {
        return $this->set->pollFirst();
    }

    public function pollLast() {
        return $this->set->pollLast();
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->set->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->set->tailCollection($fromElement, $inclusive);
    }

    public function descendingSet() {
        return $this->set->descendingSet();
    }

    public function headSet($toElement, $inclusive = true) {
        return $this->set->headSet($toElement, $inclusive);
    }

    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->set->subSet($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailSet($fromElement, $inclusive = true) {
        return $this->set->tailSet($fromElement, $inclusive);
    }

}

?>
