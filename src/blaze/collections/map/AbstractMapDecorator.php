<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractMapDecorator extends Object implements \blaze\collections\Map {

    protected $map;

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
