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
class Join extends Object implements Fromable, Joinable{

    const TYPE_NORMAL = -1;
    const TYPE_CROSS = 0;
    const TYPE_INNER = 1;
    const TYPE_LEFT = 2;
    const TYPE_RIGHT = 3;
    const TYPE_OUTER = 4;
    const TYPE_NATURAL = 8;

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

    public function addJoinType($joinType){
        $this->joinType |= $joinType;
    }
}

?>
