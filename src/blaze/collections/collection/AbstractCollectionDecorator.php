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
abstract class AbstractCollectionDecorator extends \blaze\lang\Object implements \blaze\collections\Collection {

    protected $collection;

    public function __construct(\blaze\collections\Collection $collection) {
        $this->collection = $collection;
    }

    public function add($obj) {
        return $this->collection->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return $this->collection->addAll($obj);
    }

    public function clear() {
        return $this->collection->clear();
    }

    public function contains($obj) {
        return $this->collection->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        return $this->collection->containsAll($c);
    }

    public function count() {
        return $this->collection->count();
    }

    public function isEmpty() {
        return $this->collection->isEmpty();
    }

    public function remove($obj) {
        return $this->collection->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return $this->collection->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return $this->collection->retainAll($obj);
    }

    public function toArray($type = null) {
        return $this->collection->toArray($type);
    }

}

?>
