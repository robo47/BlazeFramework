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
class WhereClause extends Object {

    private $condition;

    public function __construct(Condition $condition = null) {
        $this->condition = $condition;
    }

    /**
     *
     * @return Condition
     */
    public function getCondition() {
        return $this->condition;
    }

    /**
     *
     * @param Condition $condition
     * @return WhereClause 
     */
    public function setCondition(Condition $condition) {
        $this->condition = $condition;
        return $this;
    }

}

?>
