<?php

namespace blaze\ds\meta;

/**
 * This class represents the meta data of a column object which allows to get
 * and set properties of it and also to remove it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ColumnMetaData {

    /**
     * Drops the column represented by this object.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of this column.
     *
     * @return blaze\lang\String The name of the column
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getName();

    /**
     * Sets the name of this column.
     *
     * @param string|\blaze\lang\String $columnName The name of the column.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setName($columnName);

    /**
     * Returns the native datasource specific type of this column.
     *
     * @return blaze\lang\String The native datasource specific type
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getNativeType();

    /**
     * Returns the composed datasource specific type.
     * 
     * @return blaze\lang\String The composed datasource specific type.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getComposedNativeType();

    /**
     * Sets the native datasource specific type of this column.
     *
     * @param string|\blaze\lang\String $nativeType The native datasource specific datatype
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setNativeType($nativeType);

    /**
     * Returns the mapped native datasource type to PHP specific datatype for this column.
     *
     * @return blaze\lang\String The PHP specific datatype
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getClassType();

    /**
     * Sets the PHP specific datatype for this column.
     *
     * @param string|\blaze\lang\String $classType The PHP specific datatype
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setClassType($classType);

    /**
     * Returns the length of this column.
     *
     * @return int The length of this column.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getLength();

    /**
     * Sets the length of this column.
     * 
     * @param int $length The length of this column.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setLength($length);

    /**
     * Returns the precision of this column.
     *
     * @return int The precision of this column.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPrecision();

    /**
     * Sets the precision of this column.
     * 
     * @param int $precision The precision of this column.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setPrecision($precision);

    /**
     * Returns the default value for this column.
     *
     * @return blaze\lang\String The default value for this column.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDefault();

    /**
     * Sets the default value for this column.
     * 
     * @param string|blaze\lang\String $default The default value for this column.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setDefault($default);

    /**
     * Returns the comment for this column.
     *
     * @return blaze\lang\String The comment for this column.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getComment();

    /**
     * Returns the comment for this column.
     * 
     * @param string|blaze\lang\String $comment The comment for this column.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setComment($comment);

    /**
     * Returns wether null is an allowed value for this column or not.
     *
     * @return boolean True if null is allowed, otherwise false.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isNullable();

    /**
     * Sets wether null is an allowed value for this column or not.
     * 
     * @param boolean $nullable True if null is allowed, otherwise false.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setNullable($nullable);

    /**
     * Returns the sequence defined for this column or null if none specified.
     *
     * @return \balze\ds\meta\SequenceMetaData The sequence of the column
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequence();

    /**
     * Sets the sequence for this column.
     *
     * @param \balze\ds\meta\SequenceMetaData $sequence The sequence to add to the column
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSequence(\balze\ds\meta\SequenceMetaData $sequence = null);

    /**
     * Returns wether the column is signed or not.
     *
     * @return boolean True if the column is signed, otherwise false.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isSigned();

    /**
     * Sets wether the column is signed or not.
     *
     * @param boolean $signed True if the column is signed, otherwise false.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSigned($signed);

    /**
     * Returns wether the column is a primary key or not.
     *
     * @return boolean True if the column is a primary key, otherwise false.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isPrimaryKey();

    /**
     * Sets wether the column is a primary key or not.
     *
     * @param boolean $primaryKey True if the column is a primary key, otherwise false.
     * @param string|\blaze\lang\String $name The name of the primary key constraint.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setPrimaryKey($primaryKey, $name = null);

    /**
     * Returns wether the column is a foreign key or not.
     *
     * @return boolean True if the column is a foreign key, otherwise false.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isForeignKey();

    /**
     * Sets wether the column is a foreign key or not.
     * 
     * @param boolean $foreignKey True if the column is a foreign key, otherwise false.
     * @param \blaze\ds\meta\ColumnMetaData $referencingColumn The column to which the foreign key shall reference to
     * @param string|\blaze\lang\String $name The name of the foreign key constraint.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setForeignKey($foreignKey, \blaze\ds\meta\ColumnMetaData $referencingColumn, $name = null);

    /**
     * Returns wether the column is a unique key or not.
     *
     * @return boolean True if the column is a unique key, otherwise false.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isUniqueKey();

    /**
     * Sets wether the column is a unique key or not.
     * 
     * @param boolean $primaryKey True if the column is a unique key, otherwise false.
     * @param string|\blaze\lang\String $name The name of the unique key constraint.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setUniqueKey($uniqueKey, $name = null);

    /**
     * Returns the check constraint of this column or null if none available.
     *
     * @return \blaze\ds\meta\CheckConstraintMetaData The meta data of the check constraint.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getCheckConstraint();

    /**
     * Sets the check constraint for this column.
     *
     * @param string|\blaze\lang\String $checkConstraint The check expression.
     * @param string|\blaze\lang\String $name The name of the foreign key constraint.
     * @return \blaze\ds\meta\ColumnMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setCheckConstraint($checkConstraint, $name = null);

    /**
     * Returns the table to which this column belongs to.
     *
     * @return blaze\ds\meta\TableMetaData The table to which the column belongs to.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTable();

    /**
     * Returns the constraints which are defined for this column.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ConstraintMetaData] The constraints.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getConstraints();

    /**
     * Returns the constraint with the given name for this column. If it does not
     * exist, null is returned.
     *
     * @param string|\blaze\lang\String $constraintName The name of the constraint
     * @return \blaze\ds\meta\ConstraintMetaData The meta data object representing the constraint
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getConstraint($constraintName);

    /**
     * Returns the columns which have a reference to this column.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The referencing columns.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getReferencingColumns();
}

?>
