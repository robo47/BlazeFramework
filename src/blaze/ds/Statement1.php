<?php

namespace blaze\ds;

/**
 * Description of Statement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Statement1 {

    /**
     *
     * @param string|blaze\lang\String $sql
     */
    public function addBatch($sql);

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
     * @return integer The count of the updated rows
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
}
?>
