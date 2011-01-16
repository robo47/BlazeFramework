<?php

namespace blaze\ds;

/**
 * An object which represents the results of the execution of an query.
 *
 * It holds a cursor of the datasource which is positioned in front of the beginning of
 * the result. This cursor can be moved through the whole result set and if it is
 * scrollable, you can also go backwards or move to specific positions.
 * 
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ResultSet {
    /**
     * Specifies that the cursor of the ResultSet can only move forward.
     */
    const TYPE_FORWARD_ONLY = 1;
    /**
     * Specifies that the cursor of the ResultSet can move backwards too.
     */
    const TYPE_SCROLL = 2;

    /**
     * Moves the cursor to the next object and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function next();

    /**
     * Moves the cursor to the previous object and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function previous();

    /**
     * Closes the ResultSet
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function close();

    /**
     * Returns wether the ResultSet is closed or not.
     *
     * @return boolean
     */
    public function isClosed();

    /**
     * Returns the warnings which from the database
     *
     * @return blaze\ds\DataSourceWarning
     */
    public function getWarnings();

    /**
     * Clears the warnings which were made of the datasource end.
     */
    public function clearWarnings();

    /**
     * Returns the underlying statement which created this result set.
     *
     * @return blaze\ds\Statement
     */
    public function getStatement();

    /**
     * Returns the meta data of the result set if the query has already been executed.
     * Null is returned if no ResultSet is available.
     *
     * @return blaze\ds\meta\ResultSetMetaData The meta data of the ResultSet or null if not available.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getMetaData();
    /**
     * Returns the name of the current cursor which exists for this ResultSet.
     *
     * @return string|blaze\lang\String The name of the cursor.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getCursorName();

    /**
     * Returns the type of the ResultSet, like TYPE_SCROLL or TYPE_FORWARD_ONLY.
     *
     * @return int The type of the ResultSet.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getType();

    /**
     * Returns the number of the actual row.
     *
     * @return int The actual row number
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getRow();

    /**
     * Moves the cursor to the first object and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function first();

    /**
     * Moves the cursor to the last object and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function last();

    /**
     * Moves the cursor to the given row number and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function absolute($number);

    /**
     * Moves the cursor a relative number of rows and returns wether the position is valid or not.
     *
     * @return boolean True if the position is valid, otherwise false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function relative($count);

    /**
     * Returns the value of the column with the given identifier of this object as Array.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\collections\ArrayI The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getArray($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as BigDecimal.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\math\BigDecimal The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getDecimal($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Blob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\type\Blob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getBlob($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as boolean.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return boolean The value of the result. If value is null, the result is false.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getBoolean($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as byte.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return byte The value of the result. If value is null, the result is 0.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getByte($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as short.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return short The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getShort($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Clob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\Clob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getClob($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getDate($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getDateTime($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as double.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return double The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getDouble($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as float.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return float The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getFloat($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as int.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return int The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getInt($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as long.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return long The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getLong($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as NClob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\type\NClob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getNClob($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as String.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\lang\String The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getString($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getTime($identifier);

    /**
     * Returns the value of the column with the given identifier of this object as Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getTimestamp($identifier);
}

?>
