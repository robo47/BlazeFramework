<?php

namespace blaze\ds;

/**
 * Description of Statement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Statement1 {

    /**
     *
     * @param string|blaze\lang\String $query
     */
    public function addBatch($query);

    /**
     * Clears the current batchjobs
     */
    public function clearBatch();

    /**
     * Closes the Statement
     */
    public function close();

    /**
     * @return array An array of updateCounts
     */
    public function executeBatch();

    /**
     * @return blaze\ds\meta\ResultSetMetaData
     */
    public function getMetaData();

    /**
     * Returns the current ResultSet
     *
     * @return blaze\ds\ResultSet
     */
    public function getResultSet();

    /**
     * Returns the count of updated rows by the last query
     *
     * @return int The count of the updated rows
     */
    public function getUpdateCount();

    /**
     * Returns the warnings which from the database
     *
     * @return blaze\ds\SQLWarning
     */
    public function getWarnings();

    /**
     * Returns the Connection object
     *
     * @return blaze\ds\Connection
     */
    public function getConnection();

    /**
     * Returns wether the Statement is closed or not.
     *
     * @return boolean
     */
    public function isClosed();

    /**
     * Returns the timeout for this statement
     *
     * @return int
     */
    public function getQueryTimeout();
    /**
     * Sets the timeout for this statement
     *
     * @param int $seconds
     */
    public function setQueryTimeout($seconds);
}
?>
