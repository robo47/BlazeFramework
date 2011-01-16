<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 \blaze\ds\meta\ReferentialConstraintMetaData;

/**
 * Description of AbstractReferentialConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractReferentialConstraintMetaData extends AbstractConstraintMetaData implements ReferentialConstraintMetaData {

    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    protected $referencedColumns;

}

?>
