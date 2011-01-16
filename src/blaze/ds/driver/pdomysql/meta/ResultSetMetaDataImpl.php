<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractResultSetMetaData;

/**
 * Description of ResultSetMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ResultSetMetaDataImpl extends AbstractResultSetMetaData {

    public function __construct(\blaze\ds\ResultSet $resultSet, \PDOStatement $pdoStmt) {
        $this->resultSet = $resultSet;
        $this->pdoStmt = $pdoStmt;
        $meta = $resultSet->getStatement()->getConnection()->getMetaData();
        $this->schema = $meta->getSchema($meta->getDatabaseName());
    }

    /**
     * @return array[blaze\ds\meta\ColumnMetaData]
     * @todo check what happens when a column of the result is function based
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
     * @param int $identifier
     */
    public function getColumn($identifier) {
        $meta = $this->pdoStmt->getColumnMeta(\blaze\lang\Integer::asNative($identifier));
        return new ColumnMetaDataImpl($this->schema->getTable($meta['table']), $meta['name']);
    }

}

?>
