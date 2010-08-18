<?php

namespace blaze\collections\bag;

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
abstract class AbstractSortedBagDecorator extends AbstractBagDecorator implements \blaze\collections\bag\SortedBag {

    public function __construct(\blaze\collections\bag\SortedBag $bag) {
        parent::__construct($bag);
    }

    public function ceiling($element) {
        return $this->bag->ceiling($element);
    }

    public function comparator() {
        return $this->bag->comparator();
    }

    public function descendingBag() {
        return $this->bag->descendingBag();
    }

    public function descendingCollection() {
        return $this->bag->descendingCollection();
    }

    public function descendingIterator() {
        return $this->bag->descendingIterator();
    }

    public function first() {
        return $this->bag->first();
    }

    public function floor($element) {
        return $this->bag->floor($element);
    }

    public function headBag($toElement, $inclusive = true) {
        return $this->bag->headBag($toElement, $inclusive);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->bag->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->bag->higher($element);
    }

    public function last() {
        return $this->bag->last();
    }

    public function lower($element) {
        return $this->bag->lower($element);
    }

    public function pollFirst() {
        return $this->bag->pollFirst();
    }

    public function pollLast() {
        return $this->bag->pollLast();
    }

    public function subBag($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->bag->subBag($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->bag->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailBag($fromElement, $inclusive = true) {
        return $this->bag->tailBag($fromElement, $inclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->bag->tailCollection($fromElement, $inclusive);
    }

}

?>
