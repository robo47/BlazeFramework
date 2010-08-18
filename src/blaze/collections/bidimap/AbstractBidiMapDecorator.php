<?php

namespace blaze\collections\bidimap;

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
abstract class AbstractBidiMapDecorator extends Object implements \blaze\collections\BidiMap {

    protected $bidiMap;

    public function __construct(\blaze\collections\BidiMap $bidiMap) {
        $this->bidiMap = $bidiMap;
    }

    public function clear() {
        return $this->bidiMap->clear();
    }

    public function containsKey($key) {
        return $this->bidiMap->containsKey($key);
    }

    public function containsValue($value) {
        return $this->bidiMap->containsValue($value);
    }

    public function count() {
        return $this->bidiMap->count();
    }

    public function entrySet() {
        return $this->bidiMap->entrySet();
    }

    public function get($key) {
        return $this->bidiMap->get($key);
    }

    public function getKey($value) {
        return $this->bidiMap->getKey($value);
    }

    public function isEmpty() {
        return $this->bidiMap->isEmpty();
    }

    public function keySet() {
        return $this->bidiMap->keySet();
    }

    public function put($key, $value) {
        return $this->bidiMap->put($key, $value);
    }

    public function putAll(\blaze\collections\Map $m) {
        return $this->bidiMap->putAll($m);
    }

    public function remove($key) {
        return $this->bidiMap->remove($key);
    }

    public function removeValue($value) {
        return $this->bidiMap->removeValue($value);
    }

    public function valueSet() {
        return $this->bidiMap->valueSet();
    }

    public function values() {
        return $this->bidiMap->values();
    }

    public function containsAll(\blaze\collections\Map $obj) {
        return $this->bidiMap->containsAll($obj);
    }

    public function removeAll(\blaze\collections\Map $obj) {
        return $this->bidiMap->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Map $obj) {
        return $this->bidiMap->retainAll($obj);
    }

}

?>
