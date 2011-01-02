<?php

namespace blaze\collections\collection;

/**
 * This is a basic implementation of a CollectionDecorator which can be used to
 * give a Collection a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractCollectionDecorator extends \blaze\lang\Object implements \blaze\collections\Collection {

    /**
     * The decorated collection.
     * @var \blaze\collections\Collection
     */
    protected $collection;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\Collection $collection The decorated collection.
     */
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
    public function size(){return $this->count();}

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

    public function getIterator(){
        return $this->collection->getIterator();
    }

}

?>
