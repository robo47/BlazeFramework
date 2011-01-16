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
class SelectStatement extends FromStatement {

    protected $selectClause;

    public function __construct(SelectClause $selectClause = null, FromClause $fromClause = null, WhereClause $whereClause = null, GroupByClause $groupByClause = null, OrderByClause $orderByClause = null, LimitClause $limitClause = null) {
        $this->selectClause = $selectClause;
        parent::__construct($fromClause, $whereClause, $groupByClause, $orderByClause, $limitClause);
    }

    /**
     *
     * @return SelectClause
     */
    public function getSelectClause() {
        return $this->selectClause;
    }

    public function setSelectClause(SelectClause $selectClause) {
        $this->selectClause = $selectClause;
    }

}

?>
