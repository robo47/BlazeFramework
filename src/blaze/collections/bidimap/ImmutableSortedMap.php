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
