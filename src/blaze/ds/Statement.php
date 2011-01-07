<?php

namespace blaze\ds;

/**
 * This is the subinterface for a normal statement, because PHP does not allow
 * overloading, Statement1 is the main interface for all statement types.
 * This statement directly executes the given query.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Statement extends Statement1 {

    /**
     * Executes the given query, which may return multiple results. There are
     * a few cases which return multiple ResultSets or update counts.
     * You should not bother with that unless you expect it, or you have an unknown
     * query which may return that.
     *
     * To iterate over the ResultSets or update counts you can use getMoreResults().
     *
     * @param string|blaze\lang\String $query The unknown query
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs.
     */
    public function execute($query);

    /**
     * Executes the given query and returns a ResultSet object.
     *
     * @param string|blaze\lang\String $query The query
     * @return blaze\ds\ResultSet The result of the query but never null.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs or if the given query does not return a ResultSet.
     */
    public function executeQuery($query);

    /**
     * Executes the given update query on the datasource and returns the update count.
     *
     * @param string|blaze\lang\String $query The update query
     * @return int The count of the updated objects.
     * @throws \blaze\ds\DataSourceException If a connection error or so occurs or if the given query returns a ResultSet.
     */
    public function executeUpdate($query);
}

?>
