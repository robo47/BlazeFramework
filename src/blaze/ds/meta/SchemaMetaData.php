<?php

namespace blaze\ds\meta;

/**
 * This class represents a schema of a datasource object which can be the same
 * in some cases. Mainly it has the same functionality like DatabaseMetaData
 * but offers in addition create, read and delete operations for views and tables.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SchemaMetaData {

    /**
     * Returns the parent datasource meta object.
     *
     * @return blaze\ds\meta\DatabaseMetaData The parent datasource meta object.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseMetaData();

    /**
     * Drops the schema.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of this schema.
     *
     * @return blaze\lang\String The schema name.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchemaName();

    /**
     * Sets the name of this schema. Some datasources do
     * not support this action and throw a DataSourceException with the error code -1.
     *
     * @param string|blaze\lang\String $schemaName The schema name.
     * @return boolean Wether the action was successfull or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSchemaName($schemaName);

    /**
     * Returns the charset of this schema.
     *
     * @return blaze\lang\String The schema charset
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchemaCharset();

    /**
     * Sets the charset of this schema.
     *
     * @param string|blaze\lang\String $schemaCharset The schema collection
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSchemaCharset($schemaCharset);

    /**
     * Returns the collation of this schema.
     *
     * @return blaze\lang\String The schema colleation
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchemaCollation();

    /**
     * Sets the collation of this schema.
     *
     * @param string|blaze\lang\String $schemaCollation The schema colleation
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSchemaCollation($schemaCollation);

    /**
     * Returns the tables which are in this schema as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\TableMetaData] The tables of the schema
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTables();

    /**
     * Returns the table with the given name of the schema or null if no table
     * was found.
     *
     * @param string|\blaze\lang\String $tableName The name of the table
     * @return blaze\ds\meta\TableMetaData The table with the given name or null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTable($tableName);

    /**
     * Drops the table with the given name.
     *
     * @param string|\blaze\lang\String $tableName The name of the table
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropTable($tableName);

    /**
     * Creates a table with the given parameters. This table has to be initialized
     * with the addTable() method.
     *
     * @param string|\blaze\lang\String $tableName The name of the table
     * @param string|\blaze\lang\String $charset The charset of the table
     * @param string|\blaze\lang\String $collation The collation of the table
     * @param string|\blaze\lang\String $comment The comment of the table
     * @return blaze\ds\meta\TableMetaData The created table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createTable($tableName, $charset = null, $collation = null, $comment = null);

    /**
     * Adds the table to the schema recursively.
     *
     * @param \blaze\ds\meta\TableMetaData $table The table meta data to add to the schema.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addTable(TableMetaData $table, $newName = null);

    /**
     * Adds the sequence to the schema.
     *
     * @param \blaze\ds\meta\SequenceMetaData $sequence The sequence meta data to add to the schema.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addSequence(SequenceMetaData $sequence, $newName = null);

    /**
     * Returns the sequences which are in this schema as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\SequenceMetaData] The sequences of the schema
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequences();

    /**
     * Returns the sequence with the given name of the schema or null if no sequence
     * was found.
     *
     * @param string|\blaze\lang\String $sequenceName The name of the sequence
     * @return blaze\ds\meta\SequenceMetaData The sequence with the given name or null
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequence($sequenceName);

    /**
     * Drops the sequence with the given name.
     *
     * @param string|\blaze\lang\String $sequenceName The name of the sequence
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropSequence($sequenceName);

    /**
     * Creates a sequence with the given parameters.
     *
     * @param string|\blaze\lang\String $sequenceName The name of the sequence
     * @param string|\blaze\lang\String $sequenceType The type of the sequence
     * @param string|\blaze\lang\String $sequencePrecision The precision of the sequence
     * @param string|\blaze\lang\String $sequenceCurrentValue The current value of the sequence
     * @param string|\blaze\lang\String $sequenceIncrement The increment of the sequence
     * @return blaze\ds\meta\SequenceMetaData The created sequence
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createSequence($sequenceName, $sequenceType = null, $sequencePrecision = null, $sequenceCurrentValue = null, $sequenceIncrement = null);

    /**
     * Adds the view to the schema.
     *
     * @param \blaze\ds\meta\ViewMetaData $view The view meta data to add to the schema.
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addView(ViewMetaData $view, $newName = null);

    /**
     * Returns the views which are in this schema as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ViewMetaData] The views of the schema
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getViews();

    /**
     * Returns the view with the given name of the schema or null if no view
     * was found.
     *
     * @param string|\blaze\lang\String $viewName The name of the view
     * @return blaze\ds\meta\ViewMetaData The view with the given name or null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getView($viewName);

    /**
     * Drops the view with the given name.
     *
     * @param string|\blaze\lang\String $viewName The name of the view
     * @return blaze\ds\meta\SchemaMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropView($viewName);

    /**
     * Creates a view with the given parameters.
     *
     * @param string|\blaze\lang\String $viewName The name of the view
     * @param string|\blaze\lang\String $viewDefinition The definition of the view
     * @return blaze\ds\meta\ViewMetaData The created view.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createView($viewName, $viewDefinition);
}

?>
