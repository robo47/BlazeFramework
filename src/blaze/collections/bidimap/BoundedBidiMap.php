<?php

namespace blaze\collections\bidimap;

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
final class BoundedBidiMap implements \blaze\collections\BidiMap, \blaze\collections\Bounded {

    private $bidiMap;
    private $maxCount;

    public function __construct(\blaze\collections\BidiMap $bidiMap, $maxCount) {
        $this->bidiMap = $bidiMap;
        $this->maxCount = $maxCount;
    }

    public function clear() {

    }

    public function containsAll(Map $c) {

    }

    public function containsKey($key) {

    }

    public function containsValue($value) {

    }

    public function count() {

    }

    public function entrySet() {

    }

    public function get($key) {

    }

    public function getKey($value) {

    }

    public function isEmpty() {

    }

    public function isFull() {

    }

    public function keySet() {

    }

    public function maxCount() {

    }

    public function put($key, $value) {

    }

    public function putAll(Map $m) {

    }

    public function remove($key) {

    }

    public function removeAll(Map $obj) {

    }

    public function removeValue($value) {

    }

    public function retainAll(Map $obj) {

    }

    public function valueSet() {

    }

    public function values() {

    }

    
}

?>
