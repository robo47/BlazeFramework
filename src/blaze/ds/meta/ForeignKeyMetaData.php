<?php
namespace blaze\ds\meta;

/**
 * Description of ForeignKeyMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ForeignKeyMetaData extends ConstraintMetaData{

    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getReferencedColumn();
    public function setReferencedColumn(\blaze\ds\meta\ColumnMetaData $referencedColumn);
}

?>
