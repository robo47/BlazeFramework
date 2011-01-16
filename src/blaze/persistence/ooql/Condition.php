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
class Condition extends Object implements Argument, Conditionable {
    const COND_EQUALS = '=';
    const COND_EQUALS_NOT = '!=';
    const COND_LOWER = '<';
    const COND_EQUALS_LOWER = '=<';
    const COND_GREATER = '>';
    const COND_EQUALS_GREATER = '>=';
    const COND_IN = 'IN';
    const COND_NOT_IN = 'NOT IN';
    const COND_ANY = 'ANY';
    const COND_ALL = 'ALL';
    const COND_EXISTS = 'EXISTS';
    const COND_BETWEEN = 'BETWEEN';
    const COND_AND = 'AND';
    const COND_OR = 'OR';
    const COND_XOR = 'XOR';

    private $negation;
    private $left;
    private $right;
    private $condOperation;

    public function __construct(Conditionable $left, Conditionable $right, $condOperation, $negation = false) {
        $this->left = $left;
        $this->right = $right;
        $this->condOperation = $condOperation;
        $this->negation = $negation;
    }

    public function getLeft() {
        return $this->left;
    }

    public function getRight() {
        return $this->right;
    }

    public function getCondOperation() {
        return $this->condOperation;
    }

}

?>
