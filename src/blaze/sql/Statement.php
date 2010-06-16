<?php
namespace blaze\sql;

/**
 * Description of Statement
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Statement {

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
     *
     * @param string|blaze\lang\String $sql
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
     public function execute($sql);
     /**
      * @return array An array of updateCounts
      */
     public function executeBatch();
     /**
      *
      * @param string|blaze\lang\String $sql
      * @return blaze\sql\ResultSet
      */
     public function executeQuery($sql);
     /**
      *
      * @param <type> $sql
      * @return integer The count of the updated rows or 0 if there was no return.
      */
     public function executeUpdate($sql);
/**
      * Returns the current ResultSet
 *
      * @return blaze\sql\ResultSet
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
      * @return blaze\sql\SQLWarning
      */
     public function getWarnings();
     /**
      * Returns the Connection object
      *
      * @return blaze\sql\Connection
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
