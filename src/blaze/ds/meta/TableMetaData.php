<?php

namespace blaze\ds\meta;

/**
 * This class represents a table of a schema object with which all information
 * of the table can be get and also changed. In addition it offeres create, read
 * update and delete operations for columns, indizes, triggers and constraints.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface TableMetaData {

    /**
     * Returns the name of the table.
     *
     * @return blaze\lang\String
     */
    public function getTableName();

    /**
     * Sets the name of the table.
     *
     * @param string|blaze\lang\String $tableName
     * @return boolean
     */
    public function setTableName($tableName);

    /**
     * Returns the comment of the table.
     *
     * @return blaze\lang\String
     */
    public function getTableComment();

    /**
     * Sets the comment of the table.
     *
     * @param string|blaze\lang\String $tableComment
     * @return boolean
     */
    public function setTableComment($tableComment);

    /**
     * Returns the charset of the table.
     *
     * @return blaze\lang\String
     */
    public function getTableCharset();

    /**
     * Sets the charset of the table.
     *
     * @param string|blaze\lang\String $tableCharset
     * @return boolean
     */
    public function setTableCharset($tableCharset);

    /**
     * Returns the collation of the table.
     *
     * @return blaze\lang\String
     */
    public function getTableCollation();

    /**
     * Sets the collation of the table.
     *
     * @param string|blaze\lang\String $tableCollation
     * @return boolean
     */
    public function setTableCollation($tableCollation);

    /**
     * Returns the parent schema object.
     *
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();

    /**
     * Drops the table.
     *
     * @return boolean
     */
    public function drop();

    /**
     * Returns the columns which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns();

    /**
     * Returns the column with the given name of the table or null if no column
     * was found.
     *
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumn($columnName);

    /**
     * Drops the column with the given name.
     *
     * @return boolean
     */
    public function dropColumn($columnName);

    /**
     * Creates a column with the given parameters. This column has to be initialized
     * with the addColumn() method.
     *
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function createColumn($columnName, $columnClass, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false);

    /**
     * Adds the column to the table recursively and initializes it.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\ColumnMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addColumn(ColumnMetaData $column, $newName = null);

    /**
     * Returns the triggers which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData]
     */
    public function getTriggers();

    /**
     * Returns the trigger with the given name of the table or null if no trigger
     * was found.
     *
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function getTrigger($triggerName);

    /**
     * Drops the trigger with the given name.
     *
     * @return boolean
     */
    public function dropTrigger($triggerName);

    /**
     * Creates a trigger with the given parameters. This trigger has to be initialized
     * with the addTrigger() method.
     *
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function createTrigger($triggerName, $triggerDefinition, $triggerTiming, $triggerEvent, $triggerOrder = null, $triggerOldName = null, $triggerNewName = null);

    /**
     * Adds the trigger to the table recursively and initializes it.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\TriggerMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addTrigger(TriggerMetaData $trigger, $newName = null);

    /**
     * Returns the indizes which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData]
     */
    public function getIndizes();

    /**
     * Returns the index with the given name of the table or null if no index
     * was found.
     *
     * @return blaze\ds\meta\IndexMetaData
     */
    public function getIndex($indexName);

    /**
     * Drops the index with the given name.
     *
     * @return boolean
     */
    public function dropIndex($indexName);

    /**
     * Creates an index with the given parameters. This index has to be initialized
     * with the addIndex() method.
     *
     * @return blaze\ds\meta\IndexMetaData
     */
    public function createIndex($indexName, \blaze\collections\ListI $columns, $structure = IndexMetaData::STRUCTURE_UNKNOWN, $type = IndexMetaData::TYPE_NONE);

    /**
     * Adds the index to the table recursively and initializes it.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\IndexMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addIndex(IndexMetaData $index, $newName = null);

    /**
     * Returns the columns which have a primary key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getPrimaryKeys();

    /**
     * Returns the columns which have a foreign key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getForeignKeys();

    /**
     * Returns the columns which have a unique key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getUniqueKeys();

    /**
     * Returns the columns which are referenced by other foreign keys of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingKeys();
}

?>
