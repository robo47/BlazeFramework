<?php

namespace blaze\collections;

/**
 * Comparator which uses comparable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     \blaze\collections\Collections
 * @since   1.0
 */

class ComparableComparator {

    public static function compare(\blaze\lang\Object $o1, \blaze\lang\Object $o2) {
        if ($o1 !== null && $o1 instanceof \blaze\lang\Comparable)
            return $o1->compareTo($o2);
        throw new \blaze\lang\ClassCastException($o1 . ' is not Comparable');
    }

}

?>
