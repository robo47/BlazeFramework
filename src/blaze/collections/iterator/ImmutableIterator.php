<?php

namespace blaze\collections\iterator;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
final class ImmutableIterator implements \blaze\collections\Iterator, \blaze\collections\Immutable {

    private $iter;

    public function __construct(\blaze\collections\Iterator $iter) {
        $this->iter = $iter;
    }

    public function current() {
        return $this->iter->current();
    }

    public function hasNext() {
        return $this->iter->hasNext();
    }

    public function key() {
        return $this->iter->key();
    }

    public function next() {
        return $this->iter->next();
    }

    public function remove() {
        return;
    }

    public function rewind() {
        $this->iter->rewind();
    }

    public function valid() {
        return $this->iter->valid();
    }

}

?>
