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
     * @return blaze\lang\String The table name
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTableName();

    /**
     * Sets the name of the table.
     *
     * @param string|blaze\lang\String $tableName The table name
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTableName($tableName);

    /**
     * Returns the comment of the table.
     *
     * @return blaze\lang\String The table comment
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTableComment();

    /**
     * Sets the comment of the table.
     *
     * @param string|blaze\lang\String $tableComment The table comment
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTableComment($tableComment);

    /**
     * Returns the charset of the table.
     *
     * @return blaze\lang\String The table charset
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTableCharset();

    /**
     * Sets the charset of the table.
     *
     * @param string|blaze\lang\String $tableCharset The table charset
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTableCharset($tableCharset);

    /**
     * Returns the collation of the table.
     *
     * @return blaze\lang\String The table collation
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTableCollation();

    /**
     * Sets the collation of the table.
     *
     * @param string|blaze\lang\String $tableCollation The table collation
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTableCollation($tableCollation);

    /**
     * Returns the parent schema object.
     *
     * @return blaze\ds\meta\SchemaMetaData The parent schema object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchema();

    /**
     * Drops the table.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the columns which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The columns of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumns();

    /**
     * Returns the column with the given name of the table or null if no column
     * was found.
     *
     * @param string|\blaze\lang\String $columnName The name of the column
     * @return blaze\ds\meta\ColumnMetaData The column with the given name or null
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumn($columnName);

    /**
     * Drops the column with the given name.
     *
     * @param string|\blaze\lang\String $columnName The name of the column
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropColumn($columnName);

    /**
     * Creates a column with the given parameters. This column has to be initialized
     * with the addColumn() method.
     *
     * @param string|\blaze\lang\String $columnName The name of the column
     * @param string|\blaze\lang\String $columnClass The class type of the column
     * @param string|\blaze\lang\String $columnLength The length of the column
     * @param string|\blaze\lang\String $columnPrecision The precision of the column
     * @param string|\blaze\lang\String $columnDefault The default value of the column
     * @param string|\blaze\lang\String $columnComment The comment of the column
     * @param boolean $nullable Wether the column is nullable or not
     * @param boolean $primaryKey Wether the column is a primary key or not
     * @param boolean $uniqueKey Wether the column is a unique key or not
     * @param string|\blaze\lang\String $checkConstraint The check constraint of the column
     * @return blaze\ds\meta\ColumnMetaData The created column
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createColumn($columnName, $columnClass, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false);

    /**
     * Adds the column to the table recursively and initializes it.
     *
     * @param \blaze\ds\meta\ColumnMetaData $column The column meta data which should be added.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addColumn(ColumnMetaData $column, $newName = null);

    /**
     * Returns the triggers which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData] The triggers of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggers();

    /**
     * Returns the trigger with the given name of the table or null if no trigger
     * was found.
     *
     * @param string|\blaze\lang\String $triggerName The name of the trigger
     * @return blaze\ds\meta\TriggerMetaData The trigger with the given name or null
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTrigger($triggerName);

    /**
     * Drops the trigger with the given name.
     *
     * @param string|\blaze\lang\String $triggerName The name of the trigger
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropTrigger($triggerName);

    /**
     * Creates a trigger with the given parameters. This trigger has to be initialized
     * with the addTrigger() method.
     *
     * @param string|\blaze\lang\String $triggerName The name of the trigger
     * @param string|\blaze\lang\String $triggerDefinition The definition of the trigger
     * @param int $triggerTiming The timing of the trigger
     * @param int $triggerEvent The event of the trigger
     * @param int $triggerOrder The order of the trigger
     * @param string|\blaze\lang\String $triggerOldName The name of the old record variable of the trigger
     * @param string|\blaze\lang\String $triggerNewName The name of the new record variable of the trigger
     * @return blaze\ds\meta\TriggerMetaData The created trigger
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createTrigger($triggerName, $triggerDefinition, $triggerTiming, $triggerEvent, $triggerOrder = null, $triggerOldName = null, $triggerNewName = null);

    /**
     * Adds the trigger to the table recursively and initializes it.
     *
     * @param \blaze\ds\meta\TriggerMetaData $trigger The trigger meta data which should be added.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addTrigger(TriggerMetaData $trigger, $newName = null);

    /**
     * Returns the indizes which are in this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData] The indizes of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIndizes();

    /**
     * Returns the index with the given name of the table or null if no index
     * was found.
     *
     * @param string|\blaze\lang\String $indexName The name of the index
     * @return blaze\ds\meta\IndexMetaData The index with the given name or null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIndex($indexName);

    /**
     * Drops the index with the given name.
     *
     * @param string|\blaze\lang\String $indexName The name of the index
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropIndex($indexName);

    /**
     * Creates an index with the given parameters. This index has to be initialized
     * with the addIndex() method.
     *
     * @param string|\blaze\lang\String $indexName The name of the index
     * @param \blaze\collections\ListI $columns The columns which should be added to the index
     * @param int $structure The structure of the index
     * @param int $type The type of the index
     * @return blaze\ds\meta\IndexMetaData The created index.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createIndex($indexName, \blaze\collections\ListI $columns, $structure = IndexMetaData::STRUCTURE_UNKNOWN, $type = IndexMetaData::TYPE_NONE);

    /**
     * Adds the index to the table recursively and initializes it.
     *
     * @param \blaze\ds\meta\IndexMetaData $index The index meta data which should be added.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\TableMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addIndex(IndexMetaData $index, $newName = null);

    /**
     * Returns the columns which have a primary key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The primary keys of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPrimaryKeys();

    /**
     * Returns the columns which have a foreign key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The foreign keys of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getForeignKeys();

    /**
     * Returns the columns which have a unique key constraint of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The unique keys of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUniqueKeys();

    /**
     * Returns the columns which are referenced by other foreign keys of this table as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData] The referencing key of the table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getReferencingKeys();
}

?>
