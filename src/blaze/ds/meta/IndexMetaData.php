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
    const STRUCTURE_UNKNOWN = 0;
    const STRUCTURE_BTREE = 1;
    const STRUCTURE_HASH = 2;
    const STRUCTURE_BITMAP = 3;

    const TYPE_NONE = 0;
    const TYPE_UNIQUE = 1;
    const TYPE_FULLTEXT = 2;
    const TYPE_SPATIAL = 3;

    /**
     * Drops the index.
     *
     * @return boolean
     */
    public function drop();

    /**
     * Returns the name of the index.
     *
     * @return blaze\lang\String
     */
    public function getIndexName();

    /**
     * Sets the name of the index.
     *
     * @param string|\blaze\lang\String $indexName
     */
    public function setIndexName($indexName);

    /**
     * Returns the parent table.
     *
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();

    /**
     * Returns the columns which are affected by this index.
     *
     * @return blaze\util\ListI[blaze\ds\meta\ColumnIndexEntry]
     */
    public function getColumns();

    /**
     * Adds a column to the index.
     *
     * @param string|\blaze\lang\String $columnName
     * @param string|\blaze\lang\String $prefix
     * @param string|\blaze\lang\String $sorting
     */
    public function addColumn($columnName, $prefix = null, $sorting = 'ASC');

    /**
     * Returns the index structure. See the constants STRUCTURE_*
     * 
     * @return int
     */
    public function getIndexStructure();

    /**
     * Sets the index structure of the index. See the constants STRUCTURE_*
     *
     * @param int $indexStructure
     */
    public function setIndexStructure($indexStructure);

    /**
     * Returns the index types. See the costants TYPE_*
     *
     * @return int
     */
    public function getIndexType();

    /**
     * Sets the index type of the index. See the constants TYPE_*
     *
     * @param int $indexType
     */
    public function setIndexType($indexType);
}

?>
