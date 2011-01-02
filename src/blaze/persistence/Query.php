<?php

namespace blaze\persistence;

/**
 * Description of Query
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Query {

    const TYPE_UNDEFINED = 0;
    const TYPE_SELECT = 1;
    const TYPE_INSERT = 2;
    const TYPE_UPDATE = 3;
    const TYPE_DELETE = 4;

    /**
     * The query type, types are defined in the interface blaze\persistence\Query
     * @return int
     */
    public function getType();

//     public function setResultSetTransformer(ResultSetTransformer $resultTransformer);
//     public function setFlushMode(FlushMode $flushMode);
//     public function setFetchMode(FetchMode $fetchMode);
//     public function setCacheMode(CacheMode $cacheMode);
//     public function setCacheable($cacheable);
//     public function setLockMode(LockMode $lockMode);


    /**
     * Returns the query string
     * @return blaze\lang\String
     */
    public function getQueryString();

    /**
     * Returns the query timeout in seconds
     * @return int
     */
    public function getTimeout();
    
    /**
     * Sets the query timeout in seconds
     * @param int $seconds
     */
    public function setTimeout($seconds);

    /**
     * Executes a delete or update query
     * @return int The number of entities updated or deleted
     */
    public function executeUpdate();

//    /**
//     * Returns a scrollable result set
//     * @return blaze\persistence\ScrollableResult
//     */
//     public function scroll(ScrollMode $mode = null);
//     /**
//      * Returns an iterator for the result
//      * @return blaze\collections\Iterator
//      */
//     public function iterate();

    /**
     *
     * @return 	blaze\collections\ListI
     */
    public function getList();

    /**
     * 
     * @return blaze\lang\Object
     */
    public function getUniqueResult();

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\persistence\Query
     */
    public function setTime($identifier, \blaze\util\Date $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\persistence\Query
     */
    public function setTimestamp($identifier, \blaze\util\Date $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\math\BigDecimal $value
     * @return blaze\persistence\Query
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\Blob $value
     * @return blaze\persistence\Query
     */
    public function setBlob($identifier, \blaze\ds\type\Blob $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param boolean $value
     * @return blaze\persistence\Query
     */
    public function setBoolean($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\persistence\Query
     */
    public function setByte($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\Clob $value
     * @return blaze\persistence\Query
     */
    public function setClob($identifier, \blaze\ds\type\Clob $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\persistence\Query
     */
    public function setDate($identifier, \blaze\util\Date $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param double $value
     * @return blaze\persistence\Query
     */
    public function setDouble($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param float $value
     * @return blaze\persistence\Query
     */
    public function setFloat($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\persistence\Query
     */
    public function setInt($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param long $value
     * @return blaze\persistence\Query
     */
    public function setLong($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\NClob $value
     * @return blaze\persistence\Query
     */
    public function setNClob($identifier, \blaze\ds\type\NClob $value);

    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\persistence\Query
     */
    public function setNString($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\persistence\Query
     */
    public function setNull($identifier); //, $value);
    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\persistence\Query
     */

    public function setString($identifier, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\lang\Object $value
     * @return blaze\persistence\Query
     */
    public function setEntity($identifier, \blaze\lang\Object $value);
}

?>
