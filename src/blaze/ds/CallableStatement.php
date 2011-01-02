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
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\collections\ArrayI
     */
    
    public function getArray($identifier);
    /**
     * Returns the object which is stored at the given identifier as BigDecimal.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\math\BigDecimal
     */
    public function getDecimal($identifier);
    /**
     * Returns the object which is stored at the given identifier as Blob.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\Blob
     */
    public function getBlob($identifier);
    /**
     * Returns the object which is stored at the given identifier as boolean.
     * @param blaze\lang\String|string|int $identifier
     * @return boolean
     */
    public function getBoolean($identifier);
    /**
     * Returns the object which is stored at the given identifier as byte.
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getByte($identifier);
    /**
     * Returns the object which is stored at the given identifier as Clob.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\Clob
     */
    public function getClob($identifier);
    /**
     * Returns the object which is stored at the given identifier as Date.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier);
    /**
     * Returns the object which is stored at the given identifier as double.
     * @param blaze\lang\String|string|int $identifier
     * @return double
     */
    public function getDouble($identifier);
    /**
     * Returns the object which is stored at the given identifier as float.
     * @param blaze\lang\String|string|int $identifier
     * @return float
     */
    public function getFloat($identifier);
    /**
     * Returns the object which is stored at the given identifier as int.
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getInt($identifier);
    /**
     * Returns the object which is stored at the given identifier as long.
     * @param blaze\lang\String|string|int $identifier
     * @return long
     */
    public function getLong($identifier);
    /**
     * Returns the object which is stored at the given identifier as NClob.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\NClob
     */
    public function getNClob($identifier);
    /**
     * Varchar2
     * Returns the object which is stored at the given identifier as String.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getNString($identifier);
    /**
     * Returns the object which is stored at the given identifier as String.
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getString($identifier);
    /**
     * Returns the object which is stored at the given identifier as Time(Date).
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTime($identifier);
    /**
     * Returns the object which is stored at the given identifier as Timestamp(Date).
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier);

    /**
     * Returns wether the object which is stored at the given identifier is null or not.
     * @return boolean
     */
    public function wasNull();
}

?>
