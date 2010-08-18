<?php
namespace blaze\collections\iterator;

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
final class ImmutableMapIterator implements \blaze\collections\MapIterator, \blaze\collections\Immutable{
    private $iter;

    public function __construct(\blaze\collections\MapIterator $iter){
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

    public function getKey() {
        return $this->iter->getKey();
    }

    public function getValue() {
        return $this->iter->getValue();
    }

    public function setValue($value) {
        return;
    }


}

?>
