<?php

namespace blaze\ds\driver\pdomysql\meta;

/**
 * This is a simple implementation which just holds the values of the ColumnIndexEntry.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class ColumnIndexEntryImpl extends \blaze\ds\driver\pdobase\meta\AbstractColumnIndexEntry {

    public function __construct(\blaze\ds\meta\IndexMetaData $index, \blaze\ds\meta\ColumnMetaData $column) {
        $this->index = $index;
        $this->column = $column;
    }

    public function getPrefixLength() {
        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SHOW INDEX FROM ' . $this->index->getTable()->getSchema()->getSchemaName() . '.' . $this->index->getTable()->getTableName() . ' WHERE Key_name = ? AND Column_name = ?');
        $rs = $stmt->setString(0, $this->index->getIndexName())
                        ->setString(1, $this->column->getName())
                        ->executeQuery();

        if ($rs->next())
            return $rs->getInt('Sub_part');
        return 0;
    }

    public function getColumn() {
        return $this->column;
    }

    public function drop() {
        $this->index->dropColumn($this->column->getName());
    }

}

?>
