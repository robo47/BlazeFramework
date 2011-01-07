<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ViewMetaData;

/**
 * Description of AbstractViewMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractViewMetaData extends Object implements ViewMetaData {

    /**
     *
     * @var blaze\lang\String
     */
    protected $viewName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $viewDefinition;
    /**
     *
     * @var boolean
     */
    protected $updateable;
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    protected $schema;

    protected function checkClosed() {
        if ($this->schema->getDatabaseMetaData()->getConnection()->isClosed())
            throw new DataSourceException('Connection is already closed.');
    }

}

?>
