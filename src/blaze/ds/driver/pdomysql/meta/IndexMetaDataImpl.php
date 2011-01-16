<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractIndexMetaData;

/**
 * Description of IndexMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class IndexMetaDataImpl extends AbstractIndexMetaData {

    public function __construct(\blaze\ds\meta\TableMetaData $table, $indexName, $unique, $nullable, $indexType) {
        $this->indexName = $indexName;
        $this->table = $table;
        $this->unique = $unique;
        $this->nullable = $nullable;
        $this->indexType = $indexType;
    }

    public function getTable() {
        return $this->table;
    }

    /**
     * Returns always null because index expressions are not supported by mysql.
     */
    public function getIndexExpression() {
        return null;
    }

    /**
     * Does nothing because index expressions are not supported by mysql.
     */
    public function setIndexExpression($indexExpression) {
        return $this;
    }

    public function getColumns() {
        $columns = array();

        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SHOW INDEX FROM ' . $this->table->getSchema()->getSchemaName() . '.' . $this->table->getTableName() . ' WHERE Key_name = ?');
        $rs = $stmt->setString(0, $this->indexName)->executeQuery();

        while ($rs->next())
            $columns[] = new ColumnIndexEntryImpl($this, $this->table->getColumn($rs->getString('Column_name')));

        $rs->close();
        $stmt->close();

        return \blaze\collections\Arrays::asList($columns);
    }

    public function addColumn($indexExpression, $prefix = 0, $ascending = true) {

    }

    public function dropColumn($columnName) {

    }

    public function drop() {
        $this->table->dropIndex($this->indexName);
        return true;
    }

    public function getIndexName() {
        return $this->indexName;
    }

    public function setIndexName($indexName) {

    }

    public function isUnique(){
        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SHOW INDEX FROM ' . $this->table->getSchema()->getSchemaName() . '.' . $this->table->getTableName() . ' WHERE Key_name = ?');
        $rs = $stmt->setString(0, $this->indexName)->executeQuery();

        if($rs->next())
            return !$rs->getBoolean('Not_unique');

        return false;
    }

    public function getIndexType() {
        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SHOW INDEX FROM ' . $this->table->getSchema()->getSchemaName() . '.' . $this->table->getTableName() . ' WHERE Key_name = ?');
        $rs = $stmt->setString(0, $this->indexName)->executeQuery();

        if($rs->next()){
            switch($rs->getString('Index_type')->toUpperCase()->toNative){
                case 'BTREE':
                    return \blaze\ds\meta\IndexMetaData::TYP_BTREE;
                case 'BITMAP':
                    return \blaze\ds\meta\IndexMetaData::TYPE_BITMAP;
                case 'HASH':
                    return \blaze\ds\meta\IndexMetaData::TYPE_HASH;
                case 'FULLTEXT':
                    return \blaze\ds\meta\IndexMetaData::TYPE_FULLTEXT;
            }
        }

        return \blaze\ds\meta\IndexMetaData::TYPE_UNKNOWN;
    }

    public function setIndexType($indexType) {

    }

}

?>
