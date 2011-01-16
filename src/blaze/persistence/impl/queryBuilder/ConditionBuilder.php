<?php

namespace blaze\persistence\impl\queryBuilder;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ConditionBuilder extends \blaze\lang\Object {

    private $left;
    private $rightConditionable;
    private $operator;
    private $negation = false;

    public function __construct() {

    }

    public function condition($left, $right, $operator, $leftNegation = false, $rightNegation = false, $negation = false) {
        if ($left instanceof \blaze\persistence\ooql\Condition || $left instanceof \blaze\persistence\ooql\Value)
            $this->left = $left;
        else if (\blaze\lang\String::isType($left))
            $this->left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_STRING, $leftNegation);
        else
            $this->left = new \blaze\persistence\ooql\Value($left, \blaze\persistence\ooql\Value::TYPE_SCALAR, $leftNegation);

        if ($right instanceof \blaze\persistence\ooql\Condition || $right instanceof \blaze\persistence\ooql\Value)
            $this->rightConditionable = $right;
        else if (\blaze\lang\String::isType($right))
            $this->rightConditionable = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_STRING, $rightNegation);
        else
            $this->rightConditionable = new \blaze\persistence\ooql\Value($right, \blaze\persistence\ooql\Value::TYPE_SCALAR, $rightNegation);

        $this->operator = $operator;
        $this->negation = $negation;
        return $this;
    }

    /**
     * @return \blaze\persistence\ooql\Condition
     */
    public function buildCondition() {
        return new \blaze\persistence\ooql\Condition($this->left, $this->rightConditionable, $this->operator, $this->negation);
    }

}

?>
