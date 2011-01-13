<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\IndexMetaData;

/**
 * Description of AbstractIndexMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractIndexMetaData extends Object implements IndexMetaData {

    /**
     * @return blaze\lang\String
     */
    protected $indexName;
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    protected $table;
    /**
     * Btree, Bitmap etc.
     *
     * @return int
     */
    protected $indexStructure;
    /**
     * Unique, Fulltext etc.
     *
     * @return int
     */
    protected $indexType;
}

?>
