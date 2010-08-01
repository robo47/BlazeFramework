<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\ResultSetMetaData;

/**
 * Description of AbstractResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
