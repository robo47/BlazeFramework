<?php

namespace blaze\ds;

/**
 * Description of Statement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Statement extends Statement1 {

    /**
     *
     * @param string|blaze\lang\String $sql
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
    public function execute($sql);

    /**
     *
     * @param string|blaze\lang\String $sql
     * @return blaze\ds\ResultSet
     */
    public function executeQuery($sql);

    /**
     *
     * @param <type> $sql
     * @return int The count of the updated rows or 0 if there was no return.
     */
    public function executeUpdate($sql);
}

?>
