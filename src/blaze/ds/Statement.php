<?php

namespace blaze\ds;

/**
 * This is the root interface for statements to execute queries on a datasource and return their results.
 * Only one ResultSet may exist per statement which means that,
 * if a statement executes another query the old result set gets closed.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Statement {

    /**
     * Executes the statement with either the given query when the statement is Statement
     * or with the query passed at the creation tim when the statement is a PreparedStatement.
     * In other words, if you have a PreparedStatement, the query will be ignored.
     * If you have a simple statement you need to pass a query, otherwise
     * a NullPointerException will be thrown.
     *
     * This may return multiple results and there are
     * a few cases which return multiple ResultSets or update counts.
     * You should not bother with that unless you expect it, or you have an unknown
     * query which may return that.
     *
     * To iterate over the ResultSets or update counts you can use getMoreResults().
     *
     * @param string|blaze\lang\String $query The unknown query
     * @return boolean True when the statement returned a ResultSet, false if the updateCount was returned or there are no results.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function execute($query = null);

    /**
     * Executes the statement like the method execute(), but returns a ResultSet object.
     *
     * @param string|blaze\lang\String $query The query
     * @return blaze\ds\ResultSet The result of the query but never null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs or if the statement does not return a ResultSet.
     */
    public function executeQuery($query = null);

    /**
     * Executes the statement like the method execute(), but returns the update count.
     *
     * @param string|blaze\lang\String $query The update query
     * @return int The count of the updated objects.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs or if the statement returns a ResultSet.
     */
    public function executeUpdate($query = null);

    /**
     * Adds the given query to the batch buffer which gets executed at once
     * when executeBatch() is called. The behaviour of how queries are expected
     * to get executed right, is driver specific.
     *
     * @param string|blaze\lang\String $query The query which should be added to the batch buffer.
     */
    public function addBatch($query);

    /**
     * Clears the current batch buffer.
     */
    public function clearBatch();

    /**
     * Closes the Statement and it's open ResultSets.
     *
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function close();

    /**
     * Executes the queries within the batch buffer at once. This action runs
     * within an transaction, so it is guaranteed that all or nothing is updated.
     *
     * @return array[int] An array of updateCounts
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     * @throws \blaze\ds\BatchUpdateException If a query would return a ResultSet.
     */
    public function executeBatch();

    /**
     * Returns the current ResultSet produced by the execution or null if none available.
     *
     * @return blaze\ds\ResultSet The ResultSet or null if none available.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getResultSet();

    /**
     * Returns the type of the ResultSet which can be ResultSet::TYPE_FORWARD_ONLY or ResultSet::TYPE_SCROLL.
     *
     * @return int Wether ResultSet::TYPE_FORWARD_ONLY or ResultSet::TYPE_SCROLL.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getResultSetType();

    /**
     * Checks if there are more results and moves the cursor to the next one if available.
     * It can be specified to close the old results by setting the closeOld flag.
     *
     * @return boolean True if the next result is a ResultSet, false if the result has an update count or there are no more results.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getMoreResults();

    /**
     * Returns the count of updated rows by the last query and -1 if none were updated.
     *
     * @return int The count of the updated rows or -1 if none were updated.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getUpdateCount();

    /**
     * Returns warnings which were made of the datasource end.
     *
     * @return blaze\ds\DataSourceWarning The warning of the datasource end.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getWarnings();

    /**
     * Clears the warnings which were made of the datasource end.
     */
    public function clearWarnings();

    /**
     * Returns the related Connection object with which this statement object was created.
     *
     * @return blaze\ds\Connection Returns the connection object.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getConnection();

    /**
     * Returns wether the Statement is closed or not.
     *
     * @return boolean True if it is closed, otherwise false.
     */
    public function isClosed();

    /**
     * Returns the timeout in seconds for this statement.
     *
     * @return int The timeout in seconds.
     */
    public function getQueryTimeout();

    /**
     * Sets the timeout in seconds for this statement
     *
     * @param int $seconds The timeout in seconds.
     */
    public function setQueryTimeout($seconds);

    /**
     * Returns the name of the current cursor which exists for this statement.
     *
     * @return string|blaze\lang\String The name of the cursor.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getCursorName();

    /**
     * Sets the name of the current cursor which exists for this statement.
     *
     * @param string|blaze\lang\String $cursorName The name of the cursor.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setCursorName($cursorName);

    /**
     * Returns the number of objects which are fetched when no more are available.
     *
     * @return int The number of prefetched objects.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function getFetchSize();

    /**
     * Sets the number of objects which are fetched when no more are available.
     *
     * @param int $fetchSize The number of prefetched objects.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function setFetchSize($fetchSize);
}

?>
