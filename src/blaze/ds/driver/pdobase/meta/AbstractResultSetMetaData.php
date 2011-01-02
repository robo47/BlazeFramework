<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\ResultSetMetaData;

/**
 * Description of AbstractResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractResultSetMetaData extends Object implements ResultSetMetaData {
    /**
     *
     * @var blaze\ds\Statement1
     */
    protected $stmt;
    /**
     *
     * @var \PDOStatement
     */
    protected $pdoStmt;
    /**
     *
     * @var blaze\ds\meta\SchemaMetaData
     */
    protected $schema;
    
     /**
      * @return blaze\ds\Statement1
      */
    public function getStatement(){
        return $this->stmt;
    }
}

?>
