<?php

namespace blaze\ds\meta;

/**
 * This represents an entry of an index which as expression. This expression
 * can contain functions but some datasources only support the name of the columns.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ColumnIndexEntry {

    /**
     * Drops the index entry from the index.
     *
     * @return boolean Wether the action was successful or not
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the parent index meta data object
     *
     * @return \blaze\ds\meta\IndexMetaData The parent index meta data object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIndex();

    /**
     * Returns the column meta data for this ColumnIndexEntry
     *
     * @return \blaze\ds\meta\ColumnMetaData The column meta data
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumn();

    /**
     * Returns the prefix length for this ColumnIndexEntry
     *
     * @return int The prefix length for this ColumnIndexEntry
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPrefixLength();

//    /**
//     * Returns true if the sorting is ascending, false if descending.
//     *
//     * @return boolean True when the sorting is ascending, false if descending
//     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
//     */
//    public function getSorting();
//
//    /**
//     * Set true if the sorting is ascending, false if descending.
//     *
//     * @param boolean $ascending True when the sorting is ascending, false if descending
//     * @return \blaze\ds\meta\ColumnIndexEntry This object for chaining
//     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
//     */
//    public function setSorting($ascending);

}

?>
