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
interface Connection extends \blaze\io\Closeable{
    const TRANSACTION_NONE = 0;
    const TRANSACTION_READ_UNCOMMITTED = 1;
    const TRANSACTION_READ_COMMITTED = 2;
    const TRANSACTION_REPEATABLE_READ = 3;
    const TRANSACTION_SERIALIZABLE = 4;

     /**
      * @return blaze\ds\meta\DatabaseMetaData
      */
     public function getMetaData();
     /**
      * @return blaze\ds\meta\DatabaseMetaData
      */
     public function createDatabase($databaseName);

     public function addDatabase(meta\DatabaseMetaData $database);

     public function dropDatabase($databaseName);
     /**
      * @return boolean
      */
     public function getAutoCommit();
     /**
      *
      * @param boolean $autoCommit
      */
     public function setAutoCommit($autoCommit);
     public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED, $name = null);
     public function commit($name = null);
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
