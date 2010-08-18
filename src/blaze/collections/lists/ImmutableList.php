<?php

namespace blaze\collections\lists;

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
final class ImmutableList extends AbstractListDecorator implements \blaze\collections\Immutable {

   public function add($obj) {
        return false;
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return false;
    }

    public function addAllAt($index, \blaze\collections\Collection $c) {
        return false;
    }

    public function addAt($index, $obj) {
        return false;
    }

    public function clear() {
        return false;
    }
    public function remove($obj) {
        return null;
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return null;
    }

    public function removeAt($index) {
        return null;
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return null;
    }

    public function set($index, $obj) {
        return false;
    }
}

?>
