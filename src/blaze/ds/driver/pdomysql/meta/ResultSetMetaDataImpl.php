<?php

namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractResultSetMetaData;

/**
 * Description of ResultSetMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ResultSetMetaDataImpl extends AbstractResultSetMetaData {

    public function __construct(\blaze\ds\Statement1 $stmt, \PDOStatement $pdoStmt) {
        $this->stmt = $stmt;
        $this->pdoStmt = $pdoStmt;
        $meta = $stmt->getConnection()->getMetaData();
        $this->schema = $stmt->getConnection()->getMetaData()->getSchema($meta->getDatabaseName());
    }

    /**
     * @return array[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns() {
        $arr = array();

        for ($i = 0; $i < $this->pdoStmt->columnCount(); $i++) {
            $meta = $this->pdoStmt->getColumnMeta($i);
            $arr[] = new ColumnMetaDataImpl($this->schema->getTable($meta['table']), $meta['name']);
        }
        return $arr;
    }

    /**
     * @return blaze\ds\meta\ColumnMetaData
     * @param integer $identifier
     */
    public function getColumn($identifier) {
        $meta = $this->pdoStmt->getColumnMeta(\blaze\lang\Integer::asNative($identifier));
        return new ColumnMetaDataImpl($this->schema->getTable($meta['table']), $meta['name']);
    }

}
?>
