<?php
namespace blaze\ds\meta;

/**
 * Description of ColumnMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface ColumnMetaData {
    /**
     * @return blaze\lang\String
     */
    public function getColumnName();
    /**
     * Native database types like varchar etc.
     *
     * @return blaze\lang\String
     */
    public function getColumnTypeName();
    /**
     * PHP datatypes of the columns
     *
     * @return blaze\lang\String
     */
    public function getColumnClassName();
    /**
     * @return int
     */
    public function getColumnLength();
    /**
     * @return int
     */
    public function getColumnPrecision();
    /**
     * @return blaze\lang\String
     */
    public function getColumnDefault();
    /**
     * @return blaze\lang\String
     */
    public function getColumnComment();
    /**
     * @return boolean
     */
    public function isNullable();
    /**
     * @return boolean
     */
    public function isAutoIncrement();
    /**
     * @return boolean
     */
    public function isSigned();
    /**
     * @return boolean
     */
    public function isPrimaryKey();
    /**
     * @return boolean
     */
    public function isForeignKey();
    /**
     * @return boolean
     */
    public function isUniqueKey();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();

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
