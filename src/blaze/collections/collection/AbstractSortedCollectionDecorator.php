<?php

namespace blaze\collections\collection;

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
abstract class AbstractSortedCollectionDecorator extends AbstractCollectionDecorator implements \blaze\collections\collection\SortedCollection {

    public function __construct(\blaze\collections\SortedCollection $collection) {
        parent::__construct($collection);
    }

    public function ceiling($element) {
        return $this->collection->ceiling($element);
    }

    public function comparator() {
        return $this->collection->comparator();
    }

    public function descendingCollection() {
        return $this->collection->descendingCollection();
    }

    public function descendingIterator() {
        return $this->collection->descendingIterator();
    }

    public function first() {
        return $this->collection->first();
    }

    public function floor($element) {
        return $this->collection->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        return $this->collection->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        return $this->collection->higher($element);
    }

    public function last() {
        return $this->collection->last();
    }

    public function lower($element) {
        return $this->collection->lower($element);
    }

    public function pollFirst() {
        return $this->collection->pollFirst();
    }

    public function pollLast() {
        return $this->collection->pollLast();
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        return $this->collection->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        return $this->collection->tailCollection($fromElement, $inclusive);
    }

}

?>
