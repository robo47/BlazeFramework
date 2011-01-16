<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ConstraintMetaData;

/**
 * Description of AbstractConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractConstraintMetaData extends Object implements ConstraintMetaData {

    /**
     *
     * @var blaze\lang\String
     */
    protected $constraintName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $constraintType;

    /**
     * @return blaze\lang\String
     */
    public function getConstraintName() {
        return $this->constraintName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getConstraintType() {
        return $this->constraintType;
    }

}

?>
