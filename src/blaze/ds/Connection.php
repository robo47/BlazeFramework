<?php
namespace blaze\ds;

/**
 * Description of Connection
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Connection {
    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function close();
     /**
      * @return boolean
      */
     public function isClosed();
     /**
      * @return blaze\ds\meta\DatabaseMetaData
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
      * @return blaze\ds\Statement
      */
     public function createStatement();
     /**
      * @return blaze\ds\PreparedStatement
      */
     public function prepareStatement($sql);
     /**
      * @return blaze\ds\CallableStatement
      */
     public function prepareCall($sql);
}

?>
