<?php
namespace blaze\sql;

/**
 * Description of CallableStatement
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface CallableStatement extends PreparedStatement {
    //setOutParameter?


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
     * @return blaze\sql\type\Blob
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
     * @return blaze\sql\Clob
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
     * @return blaze\sql\type\NClob
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

    /**
     * @return boolean
     */
    public function wasNull();
}

?>
