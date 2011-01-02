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
class FromStatement extends Object implements Statement, Joinable, Conditionable{

    protected $fromClause;
    protected $whereClause;
    protected $groupByClause;
    protected $orderByClause;
    protected $limitClause;

    public function __construct(FromClause $fromClause = null, WhereClause $whereClause = null, GroupByClause $groupByClause = null, OrderByClause $orderByClause = null, LimitClause $limitClause = null) {
        $this->fromClause = $fromClause;
        $this->whereClause = $whereClause;
        $this->groupByClause = $groupByClause;
        $this->orderByClause = $orderByClause;
    }

    /**
     *
     * @return FromClause
     */
    public function getFromClause() {
        return $this->fromClause;
    }

    public function setFromClause(FromClause $fromClause) {
        $this->fromClause = $fromClause;
    }

    /**
     *
     * @return WhereClause
     */
    public function getWhereClause() {
        return $this->whereClause;
    }

    public function setWhereClause(WhereClause $whereClause) {
        $this->whereClause = $whereClause;
    }

    /**
     *
     * @return GroupByClause
     */
    public function getGroupByClause() {
        return $this->groupByClause;
    }

    public function setGroupByClause(GroupByClause $groupByClause) {
        $this->groupByClause = $groupByClause;
    }

    /**
     *
     * @return OrderByClause
     */
    public function getOrderByClause() {
        return $this->orderByClause;
    }

    public function setOrderByClause(OrderByClause $orderByClause) {
        $this->orderByClause = $orderByClause;
    }

    /**
     *
     * @return LimitClause
     */
    public function getLimitClause() {
        return $this->limitClause;
    }

    public function setLimitClause(LimitClause $limitClause) {
        $this->limitClause = $limitClause;
    }

}

?>
