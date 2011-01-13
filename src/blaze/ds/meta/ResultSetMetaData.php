<?php

namespace blaze\ds\meta;

/**
 * This represents the meta data of the ResultSet.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ResultSetMetaData {

    /**
     * Returns all columns of the ResultSet
     *
     * @return array[blaze\ds\meta\ColumnMetaData] The columns of the ResultSet
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumns();

    /**
     * Returns the column meta data for the column of the ResultSet by the given identifier.
     *
     * @param blaze\lang\String|string|int $identifier The identifier of the column
     * @return blaze\ds\meta\ColumnMetaData The column meta data
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getColumn($identifier);

    /**
     * Returns the parent ResultSet object.
     *
     * @return blaze\ds\ResultSet The parent ResultSet object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getResultSet();
}

?>
