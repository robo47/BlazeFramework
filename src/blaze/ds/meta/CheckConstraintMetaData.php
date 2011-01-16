<?php

namespace blaze\ds\meta;

/**
 * This represents a check constraint which holds additionally the check expression.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface CheckConstraintMetaData extends ConstraintMetaData {

    /**
     * Returns the definition of this check constraint.
     *
     * @return \blaze\lang\String The definition of the check constraint
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getCheckDefinition();

    /**
     * Sets the definition of this check constraint.
     *
     * @param string|\blaze\lang\String $checkDefinition The definition of the check constraint
     * @return \blaze\ds\meta\CheckConstraintMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setCheckDefinition($checkDefinition);
}

?>
