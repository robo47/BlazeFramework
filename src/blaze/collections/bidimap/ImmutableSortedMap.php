<?php

namespace blaze\collections\bidimap;

/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
final class ImmutableSortedBidiMap extends AbstractSortedBidiMapDecorator implements \blaze\collections\Immutable {

    public function clear() {
        return false;
    }

    public function put($key, $value) {
        return false;
    }

    public function putAll(\blaze\collections\Map $m) {
        return false;
    }

    public function remove($key) {
        return null;
    }

    public function removeAll(\blaze\collections\Map $obj) {
        return null;
    }

    public function retainAll(\blaze\collections\Map $obj) {
        return null;
    }

    public function removeValue($value) {
        return null;
    }

    public function pollFirst() {
        return null;
    }

    public function pollFirstEntry() {
        return null;
    }

    public function pollLast() {
        return null;
    }

    public function pollLastEntry() {
        return null;
    }

}

?>
