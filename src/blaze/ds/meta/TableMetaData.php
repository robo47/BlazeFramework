<?php
namespace blaze\ds\meta;

/**
 * Description of TableMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface TableMetaData {
    /**
     * @return blaze\lang\String
     */
    public function getTableName();
    /**
     * @param string|blaze\lang\String $tableName
     * @return boolean
     */
    public function setTableName($tableName);
    /**
     * @return blaze\lang\String
     */
    public function getTableComment();
    /**
     * @param string|blaze\lang\String $tableComment
     * @return boolean
     */
    public function setTableComment($tableComment);
    /**
     * @return blaze\lang\String
     */
    public function getTableCharset();
    /**
     * @param string|blaze\lang\String $tableCharset
     * @return boolean
     */
    public function setTableCharset($tableCharset);
    /**
     * @return blaze\lang\String
     */
    public function getTableCollation();
    /**
     * @param string|blaze\lang\String $tableCollation
     * @return boolean
     */
    public function setTableCollation($tableCollation);
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();
    /**
     * Drops the table.
     * @return boolean
     */
    public function drop();

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns();
    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumn($columnName);
    public function dropColumn($columnName);
    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function createColumn($columnName, $columnClass, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false);
    public function addColumn(ColumnMetaData $column);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData]
     */
    public function getTriggers();
    /**
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function getTrigger($triggerName);
    public function dropTrigger($triggerName);
    /**
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function createTrigger($triggerName, $triggerDefinition, $triggerTiming, $triggerEvent, $triggerOrder = null, $triggerOldName = null, $triggerNewName = null);
    public function addTrigger(TriggerMetaData $trigger);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData]
     */
    public function getIndizes();
    /**
     * @return blaze\ds\meta\IndexMetaData
     */
    public function getIndex($indexName);
    public function dropIndex($indexName);
    /**
     * @return blaze\ds\meta\IndexMetaData
     */
    public function createIndex($indexName, \blaze\collections\ListI $columns, $structure = IndexMetaData::STRUCTURE_UNKNOWN, $type = IndexMetaData::TYPE_NONE);
    public function addIndex($index);

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getPrimaryKeys();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getForeignKeys();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getUniqueKeys();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingKeys();
}

?>
