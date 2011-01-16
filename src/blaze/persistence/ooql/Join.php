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
class Join extends Object implements Fromable, Joinable {
    const TYPE_NORMAL = 0;
    const TYPE_CROSS = 1;
    const TYPE_INNER = 2;
    const TYPE_LEFT = 4;
    const TYPE_RIGHT = 8;
    const TYPE_OUTER = 16;
    const TYPE_NATURAL = 32;

    private $left;
    private $right;
    private $onClause;
    private $joinType;

    public function __construct(Joinable $left, Joinable $right, OnClause $onClause = null, $joinType = self::TYPE_NORMAL) {
        $this->left = $left;
        $this->right = $right;
        $this->onClause = $onClause;
        $this->joinType = $joinType;
    }

    public function getLeft() {
        return $this->left;
    }

    public function setLeft(Joinable $left) {
        $this->left = $left;
    }

    public function getRight() {
        return $this->right;
    }

    public function setRight(Joinable $right) {
        $this->right = $right;
    }

    public function getOnClause() {
        return $this->onClause;
    }

    public function setOnClause($onClause) {
        $this->onClause = $onClause;
    }

    public function getJoinType() {
        return $this->joinType;
    }

    public function setJoinType($joinType) {
        $this->joinType = $joinType;
    }

    public function addJoinType($joinType) {
        $this->joinType |= $joinType;
    }

}

?>
