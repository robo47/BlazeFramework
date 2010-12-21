<?php
namespace blaze\ds;

/**
 * A connection to a data source offers an abstract way of processing queries
 * to the data source end. A connection can be get by a DataSource object and should
 * be closed at the end of the application.
 * A driver has to offer transactional processing, normal, prepared and callable statements and
 * the abstraction of the meta data model with the operations create, alter and delete.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface Connection extends \blaze\io\Closeable{
    const TRANSACTION_NONE = 0;
    const TRANSACTION_READ_UNCOMMITTED = 1;
    const TRANSACTION_READ_COMMITTED = 2;
    const TRANSACTION_REPEATABLE_READ = 3;
    const TRANSACTION_SERIALIZABLE = 4;

     /**
      * Returns an objects which represents the meta data model of the data source object.
      * @return blaze\ds\meta\DatabaseMetaData
      */
     public function getMetaData();
     /**
      * Creates and returns an objects which represents the meta data model of the data source object.
      * @return blaze\ds\meta\DatabaseMetaData
      */
     public function createDatabase($databaseName);

     /**
      * Adds the data source object to the data source recursively.
      * @return boolean
      */
     public function addDatabase(meta\DatabaseMetaData $database);

     /**
      * Removes the data source object of the data source by name.
      * @return boolean
      */
     public function dropDatabase($databaseName);
     /**
      * Returns wether every statement is commited after its execution or not.
      * @return boolean
      */
     public function getAutoCommit();
     /**
      * Sets wether every statement is commited after its execution or not.
      * @param boolean $autoCommit
      */
     public function setAutoCommit($autoCommit);
     /**
      * Begins a transaction in the given isolation level with the optional transaction name.
      * Within a transaction read an write actions are synchronized so the data is consistent.
      * @param int $isolationLevel The isolation level, see constants in \blaze\ds\Connection
      * @param string|blaze\lang\String $name The name of the transaction(optional)
      */
     public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED, $name = null);
     /**
      * Commits the transaction with the given name, if no name is given the current
      * one is commited.
      * @param string|blaze\lang\String $name The name of the transaction(optional)
      */
     public function commit($name = null);
     /**
      * Rolls back every action which happened in the transaction with the given name,
      * if no name is given the current one is rolled back.
      * @param string|blaze\lang\String $name The name of the transaction(optional)
      */
     public function rollback($name = null);

     /**
      * @return blaze\ds\Statement
      */
     public function createStatement($type = ResultSet::TYPE_FORWARD_ONLY);
     /**
      * @return blaze\ds\PreparedStatement
      */
     public function prepareStatement($sql, $type = ResultSet::TYPE_FORWARD_ONLY);
     /**
      * Please Note for MySQL Set on return value not works define this vars with @!
      * @return blaze\ds\CallableStatement
      */
     public function prepareCall($sql, $type = ResultSet::TYPE_FORWARD_ONLY);
}

?>
