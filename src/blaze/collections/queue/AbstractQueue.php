<?php

namespace blaze\collections\queue;

use blaze\lang\Object;

/**
 * Some basic implementations of a Queue. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 */
abstract class AbstractQueue extends \blaze\collections\collection\AbstractCollection implements \blaze\collections\Queue {

    public function add(\blaze\lang\Reflectable $obj) {
        $this->offer($obj);
    }

}

?>
