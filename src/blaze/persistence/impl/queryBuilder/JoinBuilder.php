<?php

namespace blaze\persistence\impl\queryBuilder;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class JoinBuilder extends \blaze\lang\Object {

    private $leftEntity;
    private $rightJoinable;
    private $type;
    private $onClause;

    public function __construct() {

    }

    public function join($leftEntity, $rightEntity, $leftEntityAlias = null, $rightEntityAlias = null, $joinType = \blaze\persistence\ooql\Join::TYPE_NORMAL, \blaze\persistence\ooql\OnClause $onClause = null) {
        $this->leftEntity = new \blaze\persistence\ooql\Entity($leftEntity, $leftEntityAlias);
        $this->rightJoinable = new \blaze\persistence\ooql\Entity($rightEntity, $rightEntityAlias);
        if ($onClause !== null)
            $this->onClause = $onClause;
        $this->type = $joinType;
        return $this;
    }

    public function nestedJoin($leftEntity, \blaze\persistence\ooql\Joinable $joinable, $leftEntityAlias = null, $joinType = \blaze\persistence\ooql\Join::TYPE_NORMAL, \blaze\persistence\ooql\OnClause $onClause = null) {
        $this->leftEntity = new \blaze\persistence\ooql\Entity($leftEntity, $leftEntityAlias);
        $this->rightJoinable = $joinable;
        if ($onClause !== null)
            $this->onClause = $onClause;
        $this->type = $joinType;
        return $this;
    }

    public function on($left, $right, $operator, $leftNegation = false, $rightNegation = false, $negation = false) {
        if ($this->onClause === null)
            $this->onClause = new \blaze\persistence\ooql\OnClause();

        if (\blaze\lang\String::isType($left))
            $left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_STRING);
        else
            $left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_SCALAR);

        if (\blaze\lang\String::isType($right))
            $right = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_STRING);
        else
            $right = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_SCALAR);

        $this->onClause->setCondition(new \blaze\persistence\ooql\Condition($left, $right, $operator, $negation));
    }

    public function onCondition(\blaze\persistence\ooql\Condition $condition) {
        if ($this->onClause === null)
            $this->onClause = new \blaze\persistence\ooql\OnClause();
        $this->onClause->setCondition($condition);
    }

    /**
     * @return \blaze\persistence\ooql\Join
     */
    public function buildJoin() {
        return new \blaze\persistence\ooql\Join($this->leftEntity, $this->rightJoinable, $this->onClause, $this->type);
    }

}

?>
