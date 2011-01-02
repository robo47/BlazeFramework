<?php

namespace blaze\collections\lists;

/**
 * This is a basic implementation of a ListDecorator which can be used to
 * give a List a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractListDecorator extends \blaze\collections\collection\AbstractCollectionDecorator implements \blaze\collections\ListI {

    /**
     * The decorated list.
     * @var \blaze\collections\ListI
     */
    protected $list;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\ListI $list The decorated list.
     */
    public function __construct(\blaze\collections\ListI $list) {
        parent::__construct($list);
        $this->list = $list;
    }

    public function addAllAt($index, \blaze\collections\Collection $c) {
        return $this->list->addAllAt($index, $c);
    }

    public function addAt($index, $obj) {
        return $this->list->addAt($index, $obj);
    }

    public function get($index) {
        return $this->list->get($index);
    }

    public function indexOf($obj) {
        return $this->list->indexOf($obj);
    }

    public function lastIndexOf($obj) {
        return $this->list->lastIndexOf($obj);
    }

    public function listIterator($index = 0) {
        return $this->list->listIterator($index);
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

}

?>
