<?php

namespace blaze\persistence\impl\queryBuilder;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class FromBuilder extends AbstractBuilder {

    public function __construct() {
        $this->statement = new \blaze\persistence\ooql\FromStatement();
        $this->statement->setFromClause(new \blaze\persistence\ooql\FromClause());
        $this->statement->setWhereClause(new \blaze\persistence\ooql\WhereClause());
        $this->statement->setGroupByClause(new \blaze\persistence\ooql\GroupByClause());
        $this->statement->setOrderByClause(new \blaze\persistence\ooql\OrderByClause());
    }

    public function fromEntity($entity, $entityAlias = null) {
        $from = $this->statement->getFromClause();
        $from->addFromable(new \blaze\persistence\ooql\Entity($entity, $entityAlias));
        return $this;
    }

    public function fromSubselect(\blaze\persistence\ooql\Subselect $subselect, $alias = null) {
        $from = $this->statement->getFromClause();
        $from->addFromable($subselect);
        return $this;
    }

    public function joinEntities($leftEntity, $rightEntity, $leftEntityAlias = null, $rightEntityAlias = null, $joinType = \blaze\persistence\ooql\Join::TYPE_NORMAL, \blaze\persistence\ooql\OnClause $onClause = null) {
        $from = $this->statement->getFromClause();
        $from->addFromable(new \blaze\persistence\ooql\Join(new \blaze\persistence\ooql\Entity($leftEntity, $leftEntityAlias),
                        new \blaze\persistence\ooql\Entity($rightEntity, $rightEntityAlias),
                        $onClause, $joinType));
        return $this;
    }

    public function join(\blaze\persistence\ooql\Join $join) {
        $from = $this->statement->getFromClause();
        $from->addFromable($join);
        return $this;
    }

    public function where($left, $right, $operator, $leftNegation = false, $rightNegation = false, $negation = false) {
        $where = $this->statement->getWhereClause();
        $where->setCondition($this->getCondition($left, $right, $operator, $leftNegation, $rightNegation, $negation));
    }

    public function having($left, $right, $operator, $leftNegation = false, $rightNegation = false, $negation = false) {
        $groupby = $this->statement->getGroupByClause();
        $groupby->setHavingCondition($this->getCondition($left, $right, $operator, $leftNegation, $rightNegation, $negation));
    }

    public function whereCondition(Condition $condition) {
        $where = $this->statement->getWhereClause();
        $where->setCondition($condition);
    }

    public function havingCondition(Condition $condition) {
        $groupby = $this->statement->getGroupByClause();
        $groupby->setHavingCondition($condition);
    }

    private function getCondition($left, $right, $operator, $leftNegation = false, $rightNegation = false, $negation = false) {
        if (\blaze\lang\String::isType($left))
            $left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_STRING, $leftNegation);
        else
            $left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_SCALAR, $leftNegation);

        if (\blaze\lang\String::isType($right))
            $right = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_STRING, $rightNegation);
        else
            $right = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_SCALAR, $rightNegation);

        return new \blaze\persistence\ooql\Condition($left, $right, $operator, $negation);
    }

    public function order($property, $desc = false) {
        $orderby = $this->statement->getOrderByClause();
        $property = new \blaze\persistence\ooql\Property(null, $property, null);

        if ($desc)
            $orderby->addOrderBy($property, OrderByClause::ORD_DESC);
        else
            $orderby->addOrderBy($property, OrderByClause::ORD_ASC);
    }

    public function limit($start, $length = -1) {
        $this->statement->setLimitClause(new \blaze\persistence\ooql\LimitClause($start, $length));
    }

    public function createJoinBuilder() {
        return new JoinBuilder();
    }

    public function createConditionBuilder() {
        return new ConditionBuilder();
    }

    public function getStatement() {
        return $this->statement;
    }

}

?>
