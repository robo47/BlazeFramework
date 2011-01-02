<?php
namespace blaze\ds\meta;

/**
 * Description of ConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ConstraintMetaData{

    /**
     * Drops the constraint.
     * @return boolean
     */
    public function drop();
    /**
     * @return blaze\lang\String
     */
    public function getConstraintName();
    public function setConstraintName();
    /**
     * @return blaze\lang\String
     */
    public function getConstraintType();
    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumns();
    public function addColumn(\blaze\ds\meta\ColumnMetaData $column);
    public function removeColumn(\blaze\ds\meta\ColumnMetaData $column);
}

?>
