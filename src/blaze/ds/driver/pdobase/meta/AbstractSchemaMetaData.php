<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\SchemaMetaData;

/**
 * Description of AbstractSchemaMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSchemaMetaData extends Object implements SchemaMetaData {

    /**
     * @return blaze\ds\meta\DatabaseMetaData
     */
    protected $databaseMetaData;
    /**
     * @return blaze\lang\String
     */
    protected $schemaName;
    /**
     *
     * @var boolean
     */
    protected $initialized = false;

    protected function checkClosed() {
        if ($this->databaseMetaData->getConnection()->isClosed())
            throw new DataSourceException('Connection is already closed.');
    }

}

?>
