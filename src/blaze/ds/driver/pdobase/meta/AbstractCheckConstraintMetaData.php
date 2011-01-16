<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object;

/**
 * Description of AbstractCheckConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractCheckConstraintMetaData extends AbstractConstraintMetaData implements \blaze\ds\meta\CheckConstraintMetaData {

    /**
     * @return blaze\lang\String
     */
    protected $checkExpression;

}

?>
