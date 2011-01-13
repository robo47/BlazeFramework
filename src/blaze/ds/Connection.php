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
 * @since   1.0
 */
interface Connection extends \blaze\io\Closeable {
    const TRANSACTION_NONE = 0;
    const TRANSACTION_READ_UNCOMMITTED = 1;
    const TRANSACTION_READ_COMMITTED = 2;
    const TRANSACTION_REPEATABLE_READ = 3;
    const TRANSACTION_SERIALIZABLE = 4;

    /**
     * Creates an empty Blob object and returns it.
     * 
     * @return \blaze\ds\type\Blob
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createBlob();

    /**
     * Creates an empty Clob object and returns it.
     *
     * @return \blaze\ds\type\Clob
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createClob();

    /**
     * Creates an empty NClob object and returns it.
     *
     * @return \blaze\ds\type\NClob
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createNClob();

    /**
     * Returns an objects which represents the meta data model of the data source object.
     *
     * @return blaze\ds\meta\DatabaseMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getMetaData();
    
    /**
     * Returns warnings which were made of the datasource end.
     *
     * @return blaze\ds\DataSourceWarning The warning of the datasource end.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getWarnings();

    /**
     * Clears the warnings which were made of the datasource end.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function clearWarnings();

    /**
     * Returns the DatabaseMetaData of the database with the given name.
     *
     * @param string|\blaze\lang\String $databaseName The name of the datasource object
     * @return \blaze\ds\meta\DatabaseMetaData Returns the meta data of the database or null if no db with that name was found.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabase($databaseName);

    /**
     * Returns a list of DatabaseMetaData which represent the available databases on this host.
     *
     * @return blaze\collections\ListI[\blaze\ds\meta\DatabaseMetaData] A list of database meta data.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabases();

    /**
     * Creates and returns an objects which represents the meta data model of the data source object.
     *
     * @param string|\blaze\lang\String $databaseName The name of the datasource object
     * @param string|\blaze\lang\String $defaultCharset The default charset of the datasource object
     * @param string|\blaze\lang\String $defaultCollation The default collation of the datasource object
     * @return blaze\ds\meta\DatabaseMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createDatabase($databaseName, $defaultCharset = null, $defaultCollation = null);

    /**
     * Adds the data source object to the data source recursively and returns the new datasource object.
     *
     * @param \blaze\ds\meta\DatabaseMetaData $database The database which should be added to this endpoint.
     * @param string|\blaze\lang\String $newName The new name of the db, this overrides the name in the object
     * @return \blaze\ds\meta\DatabaseMetaData The database meta data of the new db or the given one if it has been initialized.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addDatabase(meta\DatabaseMetaData $database, $newName = null);

    /**
     * Removes the data source object of the data source by name and uninitializes it.
     *
     * @param string|\blaze\lang\String $databaseName The name of the datasource object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropDatabase($databaseName);

    /**
     * Removes the data source object of the data source by name and uninitializes it, but does not
     * throw an exception if it does not exist.
     *
     * @param string|\blaze\lang\String $databaseName The name of the datasource object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropDatabaseIfExists($databaseName);

    /**
     * Returns wether every statement is commited after its execution or not.
     *
     * @return boolean
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getAutoCommit();

    /**
     * Sets wether every statement is commited after its execution or not.
     *
     * @param boolean $autoCommit
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setAutoCommit($autoCommit);

    /**
     * Begins a transaction in the given isolation level with the optional transaction name.
     * Within a transaction read an write actions are synchronized so the data is consistent.
     *
     * @param int $isolationLevel The isolation level, see constants Connection::TRANSACTION_*
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED);

    /**
     * Returns wether a transaction is active or not.
     *
     * @return boolean True if a transaction is running, otherwise false
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isTransactionActive();

    /**
     * Returns the nesting level of transactions.
     *
     * @return int The transaction nesting level or 0 for no active transaction.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTransactionNestingLevel();
    /**
     * Sets the transaction isolation level for the current transaction.
     * Within a transaction read an write actions are synchronized so the data is consistent.
     *
     * @param int $isolationLevel The isolation level, see constants Connection::TRANSACTION_*
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTransactionIsolation($isolationLevel = Connection::TRANSACTION_READ_COMMITTED);

    /**
     * Returns the transaction isolation level of the transaction with the given name
     * or of the current one if no name is given
     * 
     * @return int The isolation level, see constants Connection::TRANSACTION_*
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTransactionIsolation();
    /**
     * Commits the transaction with the given name, if no name is given the current
     * one is commited.
     *
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function commit();

    /**
     * Rolls back every action which happened in the transaction with the given name,
     * if no name is given the current one is rolled back.
     *
     * @param \blaze\ds\Savepoint $savepoint The savepoint to roll back
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function rollback(\blaze\ds\Savepoint $savepoint = null);
    /**
     * Releases the given savepoint and savepoints which were created after this one.
     *
     * @param \blaze\ds\Savepoint $savepoint The savepoint to release
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function releaseSavepoint(\blaze\ds\Savepoint $savepoint);
    /**
     * Creates a savepoint at the current position and returns it as object.
     *
     * @param string|\blaze\lang\String $name The name of the savepoint
     * @return \blaze\ds\Savepoint The created savepoint
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSavepoint($name = null);

    /**
     * Creates a new statement object with which a request to the datasource can be made.
     *
     * @param int $type The type of the ResultSet which the statement shall produce. See ResultSet::TYPE_* constants.
     * @return blaze\ds\Statement The created Statement
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createStatement($type = ResultSet::TYPE_FORWARD_ONLY);

    /**
     * The same as createStatement, but a prepared statement gets compiled first
     * and has only to be fed with parameters to execute.
     *
     * @param string|blaze\lang\String $query The query which shall be executed
     * @param int $type The type of the ResultSet which the statement shall produce. See ResultSet::TYPE_* constants.
     * @return blaze\ds\PreparedStatement The created PreparedStatement
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function prepareStatement($query, $type = ResultSet::TYPE_FORWARD_ONLY);

    /**
     * Prepares a callable statement to call functions or procedures which are
     * located at the datasource endpoint.
     * 
     * @param string|blaze\lang\String $query The query which shall be executed
     * @param int $type The type of the ResultSet which the statement shall produce. See ResultSet::TYPE_* constants.
     * @return blaze\ds\CallableStatement The created CallableStatement
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function prepareCall($query, $type = ResultSet::TYPE_FORWARD_ONLY);
}

?>
