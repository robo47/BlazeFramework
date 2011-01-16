<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
    blaze\ds\meta\SchemaMetaData;


/**
 * Description of AbstractSequenceMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo Interface
 */
abstract class AbstractSequenceMetaData extends Object implements \blaze\ds\meta\SequenceMetaData {

    /**
     * @return \blaze\ds\meta\SchemaMetaData
     */
    protected $schema;
    /**
     * @return int
     */
    protected $currentValue;
    /**
     * @return int
     */
    protected $incrementValue;
    /**
     * @return int
     */
    protected $precision;
    /**
     * @return \blaze\lang\String
     */
    protected $name;
    /**
     * @return \blaze\lang\String
     */
    protected $classType;
    /**
     * @return \blaze\lang\String
     */
    protected $nativeType;

    public function getSchema() {
        return $this->schema;
    }
}

?>
