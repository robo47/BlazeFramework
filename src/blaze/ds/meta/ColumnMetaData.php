<?php
namespace blaze\ds\meta;

/**
 * Description of ColumnMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ColumnMetaData {

    /**
     * Drops the column.
     * @return boolean
     */
    public function drop();
    /**
     * @return blaze\lang\String
     */
    public function getName();
    public function setName($columnName);
    /**
     * Native database types like varchar etc.
     *
     * @return blaze\lang\String
     */
    public function getNativeType();
    public function setNativeType($nativeType);
    /**
     * PHP datatypes of the columns
     *
     * @return blaze\lang\String
     */
    public function getClassType();
    public function setClassType($classType);
    /**
     * @return int
     */
    public function getLength();
    public function setLength($length);
    /**
     * @return int
     */
    public function getPrecision();
    public function setPrecision($precision);
    /**
     * @return blaze\lang\String
     */
    public function getDefault();
    public function setDefault($default);
    /**
     * @return blaze\lang\String
     */
    public function getComment();
    public function setComment($comment);
    /**
     * @return boolean
     */
    public function isNullable();
    public function setNullable($nullable);
    /**
     * @return boolean
     */
    public function isAutoIncrement();
    public function setAutoIncrement($autoIncremt);
    /**
     * @return boolean
     */
    public function isSigned();
    public function setSigned($signed);
    /**
     * @return boolean
     */
    public function isPrimaryKey();
    public function setPrimaryKey($primaryKey, $name);
    /**
     * @return boolean
     */
    public function isForeignKey();
    public function setForeignKey($foreignKey, $name, ColumnMetaData $referencingColumn);
    /**
     * @return boolean
     */
    public function isUniqueKey();
    public function setUniqueKey($uniqueKey, $name);
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function setTable(\blaze\ds\meta\TableMetaData $table);

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ConstraintMetaData]
     */
    public function getConstraints();
    /**
     * @return blaze\ds\meta\ConstraintMetaData
     */
    public function getConstraint($constraintName);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingColumns();
}

?>
