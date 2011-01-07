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
     * @return blaze\ds\meta\DatabaseMetaData
     */
    public function getDatabaseMetaData();

    /**
     * Drops the schema.
     *
     * @return boolean
     */
    public function drop();

    /**
     * Returns the name of this schema.
     *
     * @return blaze\lang\String
     */
    public function getSchemaName();

    /**
     * Sets the name of this schema.
     *
     * @param string|blaze\lang\String $schemaName
     * @return boolean
     */
    public function setSchemaName($schemaName);

    /**
     * Returns the charset of this schema.
     *
     * @return blaze\lang\String
     */
    public function getSchemaCharset();

    /**
     * Sets the charset of this schema.
     *
     * @param string|blaze\lang\String $schemaCharset
     * @return boolean
     */
    public function setSchemaCharset($schemaCharset);

    /**
     * Returns the collation of this schema.
     *
     * @return blaze\lang\String
     */
    public function getSchemaCollation();

    /**
     * Sets the collation of this schema.
     *
     * @param string|blaze\lang\String $schemaCollation
     * @return boolean
     */
    public function setSchemaCollation($schemaCollation);

    /**
     * Returns the tables which are in this schema as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\TableMetaData]
     */
    public function getTables();

    /**
     * Returns the table with the given name of the schema or null if no table
     * was found.
     *
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable($tableName);

    /**
     * Drops the table with the given name.
     *
     * @return boolean
     */
    public function dropTable($tableName);

    /**
     * Creates a table with the given parameters. This table has to be initialized
     * with the addTable() method.
     *
     * @return blaze\ds\meta\TableMetaData
     */
    public function createTable($tableName, $charset = null, $collation = null, $comment = null);

    /**
     * Adds the table to the schema recursively and returns the new table.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\TableMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addTable(TableMetaData $table, $newName = null);

    /**
     * Adds the view to the schema and returns the new view.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\ViewMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addView(ViewMetaData $view, $newName = null);

    /**
     * Returns the views which are in this schema as list.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ViewMetaData]
     */
    public function getViews();

    /**
     * Returns the view with the given name of the schema or null if no view
     * was found.
     *
     * @return blaze\ds\meta\ViewMetaData
     */
    public function getView($viewName);

    /**
     * Drops the view with the given name.
     *
     * @return boolean
     */
    public function dropView($viewName);

    /**
     * Creates a view with the given parameters.
     *
     * @return blaze\ds\meta\ViewMetaData
     */
    public function createView($viewName, $viewDefinition);
}

?>
