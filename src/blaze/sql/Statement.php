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
interface Statement extends Statement1{

    /**
     *
     * @param string|blaze\lang\String $sql
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
     public function execute($sql);
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
}

?>
