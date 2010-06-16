<?php
namespace blaze\sql\driver\pdobase\meta;
use blaze\sql\meta\ColumnMetaData;

/**
 * Description of AbstractColumnMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractColumnMetaData implements ColumnMetaData {
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
     * @return integer
     */
    public function getColumnLength();
    /**
     * @return integer
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
     * @return blaze\sql\meta\TableMetaData
     */
    public function getTable();

    /**
     * @return blaze\util\ListI[blaze\sql\meta\ConstraintMetaData]
     */
    public function getConstraints();
    /**
     * @return blaze\sql\meta\ConstraintMetaData
     */
    public function getConstraint($constraintName);
}

?>
