<?php
namespace blaze\ds;

/**
 * Description of PreparedStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface PreparedStatement extends Statement1{
    /**
     *
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
    public function execute();
     /**
      *
      * @return blaze\ds\ResultSet
      */
    public function executeQuery();
     /**
      *
      * @return int The count of the updated rows or 0 if there was no return.
      */
    public function executeUpdate();

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\ArrayObject $value
     * @return blaze\lang\PreparedStatement
     */
    public function setArray($identifier, \blaze\util\ArrayObject $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\math\BigDecimal $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\Blob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBlob($identifier, \blaze\ds\type\Blob $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param boolean $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBoolean($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\lang\PreparedStatement
     */
    public function setByte($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\Clob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setClob($identifier, \blaze\ds\type\Clob $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDate($identifier, \blaze\util\Date $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param double $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDouble($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param float $value
     * @return blaze\lang\PreparedStatement
     */
    public function setFloat($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\lang\PreparedStatement
     */
    public function setInt($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param long $value
     * @return blaze\lang\PreparedStatement
     */
    public function setLong($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\NClob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNClob($identifier, \blaze\ds\type\NClob $value);
    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNString($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\lang\Object $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNull($identifier);//, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setString($identifier, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTime($identifier, \blaze\util\Date $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTimestamp($identifier, \blaze\util\Date $value);

}

?>
