<?php
namespace blaze\ds\meta;

/**
 * Description of ConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
