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
     * Returns an objects which represents the meta data model of the data source object.
     *
     * @return blaze\ds\meta\DatabaseMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getMetaData();

    /**
     * Returns the DatabaseMetaData of the database with the given name.
     *
     * @param string|blaze\lang\String $databaseName
     * @return \blaze\ds\meta\DatabaseMetaData Returns the meta data of the database or null if no db with that name was found.
     */
    public function getDatabase($databaseName);

    /**
     * Creates and returns an objects which represents the meta data model of the data source object.
     *
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
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropDatabase($databaseName);

    /**
     * Removes the data source object of the data source by name and uninitializes it, but does not
     * throw an exception if it does not exist.
     *
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropDatabaseIfExists($databaseName);

    /**
     * Returns wether every statement is commited after its execution or not.
     *
     * @return boolean
     */
    public function getAutoCommit();

    /**
     * Sets wether every statement is commited after its execution or not.
     *
     * @param boolean $autoCommit
     */
    public function setAutoCommit($autoCommit);

    /**
     * Begins a transaction in the given isolation level with the optional transaction name.
     * Within a transaction read an write actions are synchronized so the data is consistent.
     *
     * @param int $isolationLevel The isolation level, see constants in \blaze\ds\Connection
     * @param string|blaze\lang\String $name The name of the transaction(optional)
     */
    public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED, $name = null);

    /**
     * Commits the transaction with the given name, if no name is given the current
     * one is commited.
     *
     * @param string|blaze\lang\String $name The name of the transaction(optional)
     */
    public function commit($name = null);

    /**
     * Rolls back every action which happened in the transaction with the given name,
     * if no name is given the current one is rolled back.
     *
     * @param string|blaze\lang\String $name The name of the transaction(optional)
     */
    public function rollback($name = null);

    /**
     * Creates a new statement object with which a request to the datasource can be made.
     *
     * @return blaze\ds\Statement
     */
    public function createStatement($type = ResultSet::TYPE_FORWARD_ONLY);

    /**
     * The same as createStatement, but a prepared statement gets compiled first
     * and has only to be fed with parameters to execute.
     *
     * @return blaze\ds\PreparedStatement
     */
    public function prepareStatement($sql, $type = ResultSet::TYPE_FORWARD_ONLY);

    /**
     * Prepares a callable statement to call functions or procedures which are
     * located at the datasource endpoint.
     * 
     * @return blaze\ds\CallableStatement
     */
    public function prepareCall($sql, $type = ResultSet::TYPE_FORWARD_ONLY);
}

?>
