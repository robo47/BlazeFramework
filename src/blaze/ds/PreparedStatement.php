<?php

namespace blaze\ds;

/**
 * A statement which is precompiled at the datasource end and has only to be
 * called with parameters. Supported parameter forms are by index and named.
 * Index based parameters are defined with a "?" and can be set with their index
 * which begins with 0.
 * Named parameters are defined with a ":" and then the name, e.g. ":id". When
 * setting a value, the index will be only the name without the ":" char.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface PreparedStatement extends Statement {

    /**
     * Sets the value of the parameter with the given identifier to the given Array.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\collections\ArrayI $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setArray($identifier, \blaze\collections\ArrayI $value);

    /**
     * Sets the value of the parameter with the given identifier to the given BigDecimal.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\math\BigDecimal $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Blob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\ds\type\Blob $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setBlob($identifier, \blaze\ds\type\Blob $value);

    /**
     * Sets the value of the parameter with the given identifier to the given boolean.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param boolean $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setBoolean($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given byte.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param byte $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setByte($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given short.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param short $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setShort($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Clob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\ds\Clob $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setClob($identifier, \blaze\ds\type\Clob $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\util\Date $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setDate($identifier, \blaze\util\Date $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\util\Date $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setDateTime($identifier, \blaze\util\Date $value);

    /**
     * Sets the value of the parameter with the given identifier to the given double.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param double $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setDouble($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given float.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param float $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setFloat($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given int.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param int $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setInt($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given long.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param long $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setLong($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given NClob.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\ds\type\NClob $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setNClob($identifier, \blaze\ds\type\NClob $value);

    /**
     * Sets the value of the parameter with the given identifier to null.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setNull($identifier);

    /**
     * Sets the value of the parameter with the given identifier to the given String.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param string|blaze\lang\String $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setString($identifier, $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\util\Date $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setTime($identifier, \blaze\util\Date $value);

    /**
     * Sets the value of the parameter with the given identifier to the given Date.
     *
     * @param blaze\lang\String|string|int $identifier The identifier, index begins at 0
     * @param blaze\util\Date $value The parameter value
     * @return blaze\lang\PreparedStatement Returns this for chaining
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setTimestamp($identifier, \blaze\util\Date $value);
}

?>
