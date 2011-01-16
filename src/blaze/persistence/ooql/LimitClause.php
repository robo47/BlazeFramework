<?php

namespace blaze\persistence\ooql;

use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class LimitClause extends Object {

    private $start;
    private $length;

    public function __construct($start, $length = -1) {
        $this->start = $start;
        $this->length = $length;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

}

?>
