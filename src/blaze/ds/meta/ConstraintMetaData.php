<?php

namespace blaze\ds\meta;

/**
 * This class represents the meta data of a constraint object which allows to get
 * and set properties of it and also to remove it. In addition you can add to and
 * remove columns from the constraint.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ConstraintMetaData {

    /**
     * Not null constraint.
     */
    const CONSTR_NOT_NULL = 0;
    /**
     * Primary key constraint.
     */
    const CONSTR_PRIMARY_KEY = 1;
    /**
     * Foreign key constraint.
     */
    const CONSTR_REFERENTIAL = 2;
    /**
     * Unique key constraint.
     */
    const CONSTR_UNIQUE_KEY = 3;
    /**
     * Check constraint.
     */
    const CONSTR_CHECK = 4;

    
    /**
     * Drops the constraint.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of the constraint.
     *
     * @return blaze\lang\String The name of the constraint.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getConstraintName();

    /**
     * Sets the name of the constraint.
     *
     * @param string|\blaze\lang\String $constraintName The name of the constraint.
     * @return \blaze\ds\meta\ConstraintMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setConstraintName($constraintName);

    /**
     * The constraint type of this constraint. See the CONSTR_* constants.
     *
     * @return int The constraint type
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getConstraintType();

    /**
     * Returns the columns which have this constraint.
     *
     * @return blaze\ds\meta\ColumnMetaData The columns
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumns();

    /**
     * Adds this constraint to the given column.
     *
     * @param \blaze\ds\meta\ColumnMetaData $column The column which should get this constraint
     * @return \blaze\ds\meta\ConstraintMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addColumn(\blaze\ds\meta\ColumnMetaData $column);

    /**
     * Removes this constraint from the given column.
     *
     * @param \blaze\ds\meta\ColumnMetaData $column The column from which this constraint should be removed
     * @return \blaze\ds\meta\ConstraintMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function removeColumn(\blaze\ds\meta\ColumnMetaData $column);
}

?>
