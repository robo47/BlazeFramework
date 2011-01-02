<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * This is a basic implementation of a MapDecorator which can be used to
 * give a Map a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractMapDecorator extends Object implements \blaze\collections\Map {

    /**
     * The decorated map.
     * @var \blaze\collections\Map
     */
    protected $map;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\Map $map The decorated map.
     */
    public function __construct(\blaze\collections\Map $map) {
        $this->map = $map;
    }

    public function clear() {
        return $this->map->clear();
    }

    public function containsKey($key) {
        return $this->map->containsKey($key);
    }

    public function containsValue($value) {
        return $this->map->containsValue($value);
    }

    public function count() {
        return $this->map->count();
    }
    public function size(){return $this->count();}

    public function entrySet() {
        return $this->map->entrySet();
    }

    public function get($key) {
        return $this->map->getKey($value);
    }

    public function isEmpty() {
        return $this->map->isEmpty();
    }

    public function keySet() {
        return $this->map->keySet();
    }

    public function put($key, $value) {
        return $this->map->put($key, $value);
    }

    public function putAll(\blaze\collections\Map $m) {
        return $this->map->putAll($m);
    }

    public function remove($key) {
        return $this->map->remove($key);
    }

    public function values() {
        return $this->map->values();
    }

    public function containsAll(\blaze\collections\Map $obj) {
        return $this->map->containsAll($obj);
    }

    public function removeAll(\blaze\collections\Map $obj) {
        return $this->map->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Map $obj) {
        return $this->map->retainAll($obj);
    }

    public function getIterator() {
        return $this->map->getIterator();
    }

}

?>
