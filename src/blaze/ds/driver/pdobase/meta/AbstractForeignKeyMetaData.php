<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ForeignKeyMetaData;

/**
 * Description of AbstractForeignKeyMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractForeignKeyMetaData extends AbstractConstraintMetaData implements ForeignKeyMetaData {

    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    protected $referencedColumns;

}

?>
