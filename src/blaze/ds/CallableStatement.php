<?php

namespace blaze\ds;

/**
 * A callable statement is similar to a prepared statement but in this case
 * the statement is already precompiled at the data source end and has only to
 * be called with the right parameters.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface CallableStatement extends PreparedStatement {
    //setOutParameter?

    /**
     * Returns the object which is stored at the given identifier as Array.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\collections\ArrayI The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getArray($identifier);

    /**
     * Returns the object which is stored at the given identifier as BigDecimal.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\math\BigDecimal The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDecimal($identifier);

    /**
     * Returns the object which is stored at the given identifier as Blob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\type\Blob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getBlob($identifier);

    /**
     * Returns the object which is stored at the given identifier as boolean.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return boolean The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getBoolean($identifier);

    /**
     * Returns the object which is stored at the given identifier as byte.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return int The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getByte($identifier);

    /**
     * Returns the object which is stored at the given identifier as byte.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return short The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getShort($identifier);

    /**
     * Returns the object which is stored at the given identifier as Clob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\Clob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getClob($identifier);

    /**
     * Returns the object which is stored at the given identifier as Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDate($identifier);

    /**
     * Returns the object which is stored at the given identifier as double.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return double The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDouble($identifier);

    /**
     * Returns the object which is stored at the given identifier as float.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return float The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getFloat($identifier);

    /**
     * Returns the object which is stored at the given identifier as int.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return int The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getInt($identifier);

    /**
     * Returns the object which is stored at the given identifier as long.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return long The value of the result. If value is null, the result is 0
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getLong($identifier);

    /**
     * Returns the object which is stored at the given identifier as NClob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\ds\type\NClob The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getNClob($identifier);

    /**
     * Returns the object which is stored at the given identifier as String.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\lang\String The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getString($identifier);

    /**
     * Returns the object which is stored at the given identifier as Time(Date).
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTime($identifier);

    /**
     * Returns the object which is stored at the given identifier as Timestamp(Date).
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\util\Date The value of the result. If value is null, the result is null.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTimestamp($identifier);

}

?>
