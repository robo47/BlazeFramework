<?php
namespace blaze\sql;

/**
 * Description of Connection
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Connection {
    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public function close();
     /**
      * @return boolean
      */
     public function isClosed();
     /**
      * @return blaze\sql\meta\DatabaseMetaData
      */
     public function getMetaData();


     /**
      * @return boolean
      */
     public function getAutoCommit();
     /**
      *
      * @param boolean $autoCommit
      */
     public function setAutoCommit($autoCommit);
     public function beginTransaction();
     public function setTransactionIsolation($level);
     public function getTransactionIsolation();
     public function commit();
     public function rollback();

     /**
      * @return blaze\sql\Statement
      */
     public function createStatement();
     /**
      * @return blaze\sql\PreparedStatement
      */
     public function prepareStatement($sql);
     /**
      * @return blaze\sql\CallableStatement
      */
     public function prepareCall($sql);
}

?>
