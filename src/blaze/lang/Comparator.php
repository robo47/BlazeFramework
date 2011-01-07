<?php

namespace blaze\lang;

/**
 * Description of Comparable
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author  Christian Beikov
 */
interface Comparator {
    public function compare(Reflectable $o1, Reflectable $o2);
}

?>