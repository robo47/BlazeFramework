<?php

namespace blaze\persistence\impl\queryBuilder;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SelectBuilder extends FromBuilder {

    public function __construct() {
        $this->statement = new \blaze\persistence\ooql\SelectStatement();
        $this->statement->setSelectClause(new \blaze\persistence\ooql\SelectClause(\blaze\persistence\ooql\SelectClause::TYPE_NONE));
        $this->statement->setFromClause(new \blaze\persistence\ooql\FromClause());
    }

    /**
     *
     * @return SelectBuilder
     */
    public function selectAll() {
        $sel = $this->statement->getSelectClause();
        $sel->setSelectType($sel->getSelectType() | \blaze\persistence\ooql\SelectClause::TYPE_ALL);
        return $this;
    }

    /**
     *
     * @return SelectBuilder
     */
    public function selectDistinct() {
        $sel = $this->statement->getSelectClause();
        $sel->setSelectType($sel->getSelectType() | \blaze\persistence\ooql\SelectClause::TYPE_DISTINCT);
        return $this;
    }

    /**
     *
     * @param string|blaze\lang\String $property
     * @param string|blaze\lang\String $entityAlias
     * @param string|blaze\lang\String $propertyAlias
     * @return SelectBuilder 
     */
    public function selectProperty($property, $entityAlias = null, $propertyAlias = null) {
        $sel = $this->statement->getSelectClause();
        $sel->addSelectable(new \blaze\persistence\ooql\Property($entityAlias, $property, $propertyAlias));
        return $this;
    }

    /**
     * @see blaze\persistence\Formulas
     * @param \blaze\persistence\ooql\Formula $formula
     * @return SelectBuilder 
     */
    public function selectFormula(\blaze\persistence\ooql\Formula $formula) {
        $sel = $this->statement->getSelectClause();
        $sel->addSelectable($formula);
        return $this;
    }

}

?>
