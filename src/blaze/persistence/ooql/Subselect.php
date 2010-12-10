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
class Subselect extends SelectStatement implements Fromable{

    private $alias;

    public function __construct(SelectClause $selectClause = null, FromClause $fromClause = null, WhereClause $whereClause = null, GroupByClause $groupByClause = null, OrderByClause $orderByClause = null, LimitClause $limitClause = null, $alias = null) {
        $this->alias = $alias;
        parent::__construct($selectClause, $fromClause, $whereClause, $groupByClause, $orderByClause, $limitClause);
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public static function fromStatement(FromStatement $statement, $alias = null){
        if($statement instanceof SelectStatement)
            return new Subselect($this->selectClause, $this->fromClause, $this->whereClause, $this->groupByClause, $this->orderByClause, $this->limitClause, $alias);
        else
            return new Subselect(null, $this->fromClause, $this->whereClause, $this->groupByClause, $this->orderByClause, $this->limitClause, $alias);
    }

}

?>
