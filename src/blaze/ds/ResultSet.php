<?php
namespace blaze\ds;

/**
 * Description of ResultSet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ResultSet {
    const TYPE_FORWARD_ONLY = 1;
    const TYPE_SCROLL = 2;
    
    /**
     * @return boolean
     */
    public function next();
    /**
     * @return boolean
     */
    public function previous();
    /**
     * Closes the ResultSet
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
     *
     * @return blaze\ds\Statement
     */
    public function getStatement();
    /**
     * Returns the type of the ResultSet, like TYPE_SCROLL or TYPE_FORWARD_ONLY
     *
     * @return int
     */
    public function getType();
    /**
     *
     * @return int The actual row number
     */
    public function getRow();
    /**
     *
     * @return boolean Moves the cursor to the first row
     */
    public function first();
    /**
     *
     * @return boolean Moves the cursor to the last row
     */
    public function last();
    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function absolute($number);
    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function relative($count);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\collections\ArrayI
     */
    public function getArray($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\math\BigDecimal
     */
    public function getDecimal($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\Blob
     */
    public function getBlob($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return boolean
     */
    public function getBoolean($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getByte($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\Clob
     */
    public function getClob($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getDateTime($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return double
     */
    public function getDouble($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return float
     */
    public function getFloat($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getInt($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return long
     */
    public function getLong($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\NClob
     */
    public function getNClob($identifier);
    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getNString($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getString($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTime($identifier);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier);
}

?>
