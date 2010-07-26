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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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
