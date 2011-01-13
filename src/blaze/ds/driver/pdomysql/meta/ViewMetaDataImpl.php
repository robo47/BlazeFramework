<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractViewMetaData;

/**
 * Description of ViewMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class ViewMetaDataImpl extends AbstractViewMetaData {

    public function __construct(\blaze\ds\meta\SchemaMetaData $schemaMetaData, $viewName, $viewDefinition, $updateable) {
        $this->schema = $schemaMetaData;
        $this->viewName = $viewName;
        $this->viewDefinition = $viewDefinition;
        $this->updateable = $updateable;
    }

    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema() {
        return $this->schema;
    }

    /**
     * @return blaze\lang\String
     */
    public function getViewName() {
        return $this->viewName;
    }

    public function setViewName($viewName) {
        $this->checkClosed();
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
        $stmt->executeQuery('RENAME TABLE ' . $this->viewName . ' TO ' . $viewName);
        $this->viewName = $viewName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getViewDefinition() {
        return $this->viewDefinition;
    }

    public function setViewDefinition($viewDefinition) {
        $this->checkClosed();
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
        $stmt->executeQuery('ALTER VIEW ' . $this->viewName . ' AS ' . $viewDefinition);
        $this->viewDefinition = $viewDefinition;
    }

    /**
     * @return boolean
     */
    public function isUpdateable() {
        return $this->updateable;
    }

    public function drop() {
        $this->schema->dropView($this->viewName);
        return true;
    }

}

?>
