<?php

namespace blaze\collections\lists;

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
abstract class AbstractListDecorator extends \blaze\lang\Object implements \blaze\collections\ListI {

    protected $list;

    public function __construct(\blaze\collections\ListI $list) {
        $this->list = $list;
    }

    public function add($obj) {
        return $this->list->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return $this->list->addAll($obj);
    }

    public function addAllAt($index, \blaze\collections\Collection $c) {
        return $this->list->addAllAt($index, $c);
    }

    public function addAt($index, $obj) {
        return $this->list->addAt($index, $obj);
    }

    public function clear() {
        return $this->list->clear();
    }

    public function contains($obj) {
        return $this->list->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        return $this->list->containsAll($c);
    }

    public function count() {
        return $this->list->count();
    }

    public function get($index) {
        return $this->list->get($index);
    }

    public function indexOf($obj) {
        return $this->list->indexOf($obj);
    }

    public function isEmpty() {
        return $this->list->isEmpty();
    }

    public function lastIndexOf($obj) {
        return $this->list->lastIndexOf($obj);
    }

    public function listIterator($index = 0) {
        return $this->list->listIterator($index);
    }

    public function getIterator() {
        return $this->list->getIterator();
    }

    public function remove($obj) {
        return $this->list->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return $this->list->removeAll($obj);
    }

    public function removeAt($index) {
        return $this->list->removeAt($index);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return $this->list->retainAll($obj);
    }

    public function set($index, $obj) {
        return $this->list->set($index, $obj);
    }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {
        return $this->list->subList($fromIndex, $toIndex, $fromInclusive, $toInclusive);
    }

    public function toArray($type = null) {
        return $this->list->toArray($type);
    }

}

?>
