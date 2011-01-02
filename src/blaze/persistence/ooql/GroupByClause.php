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
class GroupByClause extends Object{

    private $groupBys = array();
    private $havingCondition;

    public function __construct() {
    }

    public function getGroupBys() {
        return $this->groupBys;
    }

    public function addSelectable(Property $property) {
        $this->groupBys[] = $property;
    }

    public function getHavingCondition() {
        return $this->havingCondition;
    }

    public function setHavingCondition(Condition $havingCondition) {
        $this->havingCondition = $havingCondition;
    }

}

?>
