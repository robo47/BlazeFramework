<?php

namespace blaze\ds\meta;

/**
 * This represents a foreign key constraint which holds additionally a column
 * to which it references.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ReferentialConstraintMetaData extends ConstraintMetaData {

    /**
     * Returns the referenced column for this ReferentialConstraintMetaData.
     *
     * @return blaze\ds\meta\ColumnMetaData The referenced column.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getReferencedColumn();

    /**
     * Sets the referenced column for this ReferentialConstraintMetaData.
     *
     * @return \blaze\ds\meta\ReferentialConstraintMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setReferencedColumn(\blaze\ds\meta\ColumnMetaData $referencedColumn);
}

?>
