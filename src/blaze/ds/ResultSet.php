<?php
namespace blaze\ds;

/**
 * Description of ResultSet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface ResultSet {

    /**
     * @return boolean
     */
    public function next();
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
     * @return blaze\ds\SQLWarning
     */
    public function getWarnings();
    /**
     *
     * @return blaze\ds\Statement
     */
    public function getStatement();

    /**
     *
     * @return integer The actual row number
     */
    public function getRow();
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
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\ArrayObject
     */
    public function getArray($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\math\BigDecimal
     */
    public function getDecimal($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\ds\type\Blob
     */
    public function getBlob($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return boolean
     */
    public function getBoolean($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
     */
    public function getByte($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\ds\Clob
     */
    public function getClob($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return double
     */
    public function getDouble($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return float
     */
    public function getFloat($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
     */
    public function getInt($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return long
     */
    public function getLong($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\ds\type\NClob
     */
    public function getNClob($identifier);
    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\lang\String
     */
    public function getNString($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\lang\String
     */
    public function getString($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getTime($identifier);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier);
}

?>
