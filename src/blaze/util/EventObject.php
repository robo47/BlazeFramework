<?php

namespace blaze\util;

use blaze\lang\Object;

/**
 * Description of PhaseEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class EventObject extends Object {

    protected $source;

    public function __construct(\blaze\lang\Reflectable $source) {
        $this->source = $source;
    }

    public function getSource() {
        return $this->source;
    }

}

?>
