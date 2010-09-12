<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class SelectStatement extends Object implements Statement, Fromable, Joinable, Conditionable{

    private $selectClause;
    private $fromClause;
    private $whereClause;
    private $groupByClause;
    private $orderByClause;
    private $limitClause;

    public function __construct(SelectClause $selectClause, FromClause $fromClause, WhereClause $whereClause = null, GroupByClause $groupByClause = null, OrderByClause $orderByClause = null, LimitClause $limitClause = null) {
        $this->selectClause = $selectClause;
        $this->fromClause = $fromClause;
        $this->whereClause = $whereClause;
        $this->groupByClause = $groupByClause;
        $this->orderByClause = $orderByClause;
    }
    
    public function getSelectClause() {
        return $this->selectClause;
    }

    public function setSelectClause(SelectClause $selectClause) {
        $this->selectClause = $selectClause;
    }

    public function getFromClause() {
        return $this->fromClause;
    }

    public function setFromClause(FromClause $fromClause) {
        $this->fromClause = $fromClause;
    }

    public function getWhereClause() {
        return $this->whereClause;
    }

    public function setWhereClause(WhereClause $whereClause) {
        $this->whereClause = $whereClause;
    }

    public function getGroupByClause() {
        return $this->groupByClause;
    }

    public function setGroupByClause(GroupByClause $groupByClause) {
        $this->groupByClause = $groupByClause;
    }

    public function getOrderByClause() {
        return $this->orderByClause;
    }

    public function setOrderByClause(OrderByClause $orderByClause) {
        $this->orderByClause = $orderByClause;
    }

    public function getLimitClause() {
        return $this->limitClause;
    }

    public function setLimitClause(LimitClause $limitClause) {
        $this->limitClause = $limitClause;
    }

}

?>
