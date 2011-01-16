<?php

namespace blaze\ds\meta;

/**
 * This class represents an index of columns with which all information
 * of the index can be get and also changed.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface IndexMetaData {

    /**
     * Index type none
     */
    const TYPE_UNKNOWN = 0;
    /**
     * Index type btree
     */
    const TYPE_BTREE = 1;
    /**
     * Index type hash
     */
    const TYPE_HASH = 2;
    /**
     * Index type bitmap
     */
    const TYPE_BITMAP = 3;
    /**
     * Index type fulltext
     */
    const TYPE_FULLTEXT = 4;

    /**
     * Drops the index.
     *
     * @return boolean Wether the action was successful or not
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of the index.
     *
     * @return blaze\lang\String The index name
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIndexName();

    /**
     * Sets the name of the index.
     *
     * @param string|\blaze\lang\String $indexName The index name
     * @return blaze\ds\meta\IndexMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setIndexName($indexName);

    /**
     * Returns the parent table.
     *
     * @return blaze\ds\meta\TableMetaData The parent table
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTable();

    /**
     * Returns the columns which are affected by this index.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnIndexEntry] The columns
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumns();

    /**
     * Adds a column to the index.
     *
     * @param string|\blaze\lang\String $indexExpression The index expression
     * @param int $prefix The prefix length
     * @param boolean $ascending True if ascending, otherwise false
     * @return blaze\ds\meta\IndexMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addColumn($indexExpression, $prefix = 0, $ascending = true);

    /**
     * Returns wether the index has only unique value or not
     * 
     * @return boolean True if only unique values can be hold, otherwise false.
     */
    public function isUnique();

    /**
     * Returns the index types. See the costants TYPE_*
     *
     * @return int The index type
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIndexType();

    /**
     * Sets the index type of the index. See the constants TYPE_*
     *
     * @param int $indexType The index type
     * @return blaze\ds\meta\IndexMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setIndexType($indexType);
}

?>
