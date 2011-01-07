<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractTableMetaData;

/**
 * Description of TableMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class TableMetaDataImpl extends AbstractTableMetaData {

    private $initialized;
    /**
     *
     * @var array[\blaze\ds\meta\ColumnMetaData]
     */
    private $notInitializedColumns = array();

    public function __construct(\blaze\ds\meta\SchemaMetaData $schema = null, $tableName = null, $tableComment = null, $tableCharset = null, $tableCollation = null, $initialized = true) {
        $this->schema = $schema;
        $this->tableName = $tableName;
        $this->tableComment = $tableComment;
        $this->tableCharset = $tableCharset;
        $this->tableCollation = $tableCollation;
        $this->initialized = $initialized;
    }

    public function initialize(\blaze\ds\meta\SchemaMetaData $schema, $newName = null) {
        if ($newName !== null)
            $this->tableName = $newName;
        $query = 'CREATE TABLE ' . $this->tableName . '(';

        if (count($this->notInitializedColumns) > 0) {
            foreach ($this->notInitializedColumns as $column) {
                $query .= $this->getColumnDefinition($column);
                $query .= ',';
            }

            $query = substr($query, 0, strlen($query) - 1);
        }

        $query .= ') ENGINE InnoDB';
        if ($this->tableCharset !== null)
            $query .= ' CHARACTER SET ' . $this->tableCharset;
        if ($this->tableCollation !== null)
            $query .= ' COLLATE ' . $this->tableCollation;
        if ($this->tableComment !== null)
            $query .= ' COMMENT \'' . $this->tableComment . '\'';

        $schema->getDatabaseMetaData()->getConnection()->createStatement()->executeQuery($query);
        $this->schema = $schema;
        $this->initialized = true;

        if (count($this->notInitializedColumns) > 0)
            foreach ($this->notInitializedColumns as $column)
                $column->initialize($this);

        $this->notInitializedColumns = array();
    }

    private function getColumnDefinition(\blaze\ds\meta\ColumnMetaData $column, $newName = null) {
        if ($newName === null)
            $query = $column->getName() . ' ' . $column->getComposedNativeType();
        else
            $query = $newName . ' ' . $column->getComposedNativeType();

        if (!$column->isNullable())
            $query .= ' NOT NULL';
        if ($column->getDefault() !== null)
            $query .= ' DEFAULT ' . $column->getDefault();
        if ($column->isAutoincrement())
            $query .= ' AUTO_INCREMENT';
        if ($column->isPrimaryKey())
            $query .= ' PRIMARY KEY';
        else if ($column->isUniqueKey())
            $query .= ' UNIQUE KEY';
        if ($column->getComment() !== null)
            $query .= ' COMMENT \'' . $column->getComment() . '\'';

        return $query;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTableName() {
        return $this->tableName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTableComment() {
        return $this->tableComment;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTableCharset() {
        return $this->tableCharset;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTableCollation() {
        return $this->tableCollation;
    }

    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema() {
        return $this->schema;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns() {
        if (!$this->initialized)
            return \blaze\collections\Arrays::asList($this->notInitializedColumns);
        $stmt = null;
        $rs = null;
        $columns = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $columns[] = new ColumnMetaDataImpl($this, $rs->getString('COLUMN_NAME'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $columns;
    }

    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumn($columnName) {
        if (!$this->initialized)
            return array_key_exists($columnName, $this->notInitializedColumns) ? $this->notInitializedColumns[$columnName] : null;
        $stmt = null;
        $rs = null;
        $column = null;

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->setString(2, $columnName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if ($rs->next())
                $column = new ColumnMetaDataImpl($this, $rs->getString('COLUMN_NAME'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $column;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData]
     */
    public function getTriggers() {
        if (!$this->initialized)
            return null;
        $stmt = null;
        $rs = null;
        $triggers = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $triggers[] = new TriggerMetaDataImpl($this, $rs->getString('ACTION_TIMING'),
                                $rs->getString('EVENT_MANIPULATION'),
                                $rs->getString('ACTION_ORDER'),
                                $rs->getString('TRIGGER_NAME'),
                                $rs->getString('ACTION_STATEMENT'),
                                $rs->getString('ACTION_REFERENCE_OLD_ROW'),
                                $rs->getString('ACTION_REFERENCE_NEW_ROW'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $triggers;
    }

    /**
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function getTrigger($triggerName) {
        if (!$this->initialized)
            return null;
        $stmt = null;
        $rs = null;
        $trigger = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->setString(1, $triggerName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if ($rs->next())
                $trigger = new TriggerMetaDataImpl($this, $rs->getString('ACTION_TIMING'),
                                $rs->getString('EVENT_MANIPULATION'),
                                $rs->getString('ACTION_ORDER'),
                                $rs->getString('TRIGGER_NAME'),
                                $rs->getString('ACTION_STATEMENT'),
                                $rs->getString('ACTION_REFERENCE_OLD_ROW'),
                                $rs->getString('ACTION_REFERENCE_NEW_ROW'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $trigger;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData]
     */
    public function getIndizes() {
        if (!$this->initialized)
            return null;
        $stmt = null;
        $rs = null;
        $indizes = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SHOW INDEX FROM ' . $this->schema->getSchemaName() . '.' . $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $indizes[] = new IndexMetaDataImpl($this, $rs->getString('Key_Name'),
                                !$rs->getBoolean('Non_unique'),
                                $rs->getString('Null')->equalsIgnoreCase('YES'),
                                $rs->getString('Index_type'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $indizes;
    }

    /**
     * @return blaze\ds\meta\IndexMetaData
     */
    public function getIndex($indexName) {
        if (!$this->initialized)
            return null;
        $stmt = null;
        $rs = null;
        $index = null;

        try {
            $stmt = $this->schema
                            ->getDatabaseMetaData()
                            ->getConnection()
                            ->prepareStatement('SHOW INDEX FROM ' . $this->schema->getSchemaName() . '.' . $this->tableName . ' WHERE Key_name = \'' . \blaze\lang\String::asNative($indexName) . '\'');
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if ($rs->next())
                $index = new IndexMetaDataImpl($this, $rs->getString('Key_name'),
                                !$rs->getBoolean('Non_unique'),
                                $rs->getString('Null')->equalsIgnoreCase('YES'),
                                $rs->getString('Index_type'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $index;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getPrimaryKeys() {
        if (!$this->initialized)
            return null;
        $arr = array();
        $cols = $this->getColumns();

        for ($i = 0; $i < count($cols); $i++)
            if ($cols[$i]->isPrimaryKey())
                $arr[] = $cols[$i];
        return $arr;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getForeignKeys() {
        if (!$this->initialized)
            return null;
        $arr = array();
        $cols = $this->getColumns();

        for ($i = 0; $i < count($cols); $i++)
            if ($cols[$i]->isForeignKey())
                $arr[] = $cols[$i];
        return $arr;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getUniqueKeys() {
        if (!$this->initialized)
            return null;
        $arr = array();
        $cols = $this->getColumns();

        for ($i = 0; $i < count($cols); $i++)
            if ($cols[$i]->isUniqueKey())
                $arr[] = $cols[$i];
        return $arr;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingKeys() {
        if (!$this->initialized)
            return null;
        $stmt = null;
        $rs = null;
        $columns = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = ? AND REFERENCED_TABLE_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $columns[] = new ColumnMetaDataImpl($this->getSchema()
                                        ->getDatabaseMetaData()
                                        ->getSchema($rs->getString('TABLE_SCHEMA'))
                                        ->getTable($rs->getString('TABLE_NAME')), $rs->getString('COLUMN_NAME'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $columns;
    }

    public function addColumn(\blaze\ds\meta\ColumnMetaData $column, $newName = null) {
        if (!$this->initialized) {
            if ($newName === null)
                $this->notInitializedColumns[\blaze\lang\String::asNative($column->getName())] = $column;
            else
                $this->notInitializedColumns[\blaze\lang\String::asNative($newName)] = $column;
        }else {
            $this->checkClosed();
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
            $stmt->executeQuery('ALTER TABLE ' . $this->tableName . ' ADD COLUMN ' . $this->getColumnDefinition($column, $newName));
        }
    }

    public function addIndex(\blaze\ds\meta\IndexMetaData $index, $newName = null) {
        if (!$this->initialized)
            return false;
    }

    public function addTrigger(\blaze\ds\meta\TriggerMetaData $trigger, $newName = null) {
        if (!$this->initialized)
            return false;
    }

    public function createColumn($columnName, $columnClass, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false) {
        return new ColumnMetaDataImpl(null, $columnName, $columnClass, $columnLength, $columnPrecision, $columnDefault, $columnComment, $nullable, $primaryKey, $uniqueKey, false);
    }

    public function createIndex($indexName, \blaze\collections\ListI $columns, $structure = IndexMetaData::STRUCTURE_UNKNOWN, $type = IndexMetaData::TYPE_NONE) {
        if (!$this->initialized)
            return null;
    }

    public function createTrigger($triggerName, $triggerDefinition, $triggerTiming, $triggerEvent, $triggerOrder = null, $triggerOldName = null, $triggerNewName = null) {
        if (!$this->initialized)
            return null;
    }

    public function drop() {
        if (!$this->initialized)
            return;
    }

    public function dropColumn($columnName) {
        $columnName = \blaze\lang\String::asNative($columnName);
        if (!$this->initialized && array_key_exists($columnName, $this->notInitializedColumns)) {
            unset($this->notInitializedColumns[$columnName]);
        } else {

        }
    }

    public function dropIndex($indexName) {

    }

    public function dropTrigger($triggerName) {

    }

    public function setTableCharset($tableCharset) {
        if (!$this->initialized)
            $this->tableCharset = $tableCharset;
        else {

        }
    }

    public function setTableCollation($tableCollation) {
        if (!$this->initialized)
            $this->tableCollation = $tableCollation;
        else {

        }
    }

    public function setTableComment($tableComment) {
        if (!$this->initialized)
            $this->tableComment = $tableComment;
        else {

        }
    }

    public function setTableName($tableName) {
        if (!$this->initialized)
            $this->tableName = $tableName;
        else {

        }
    }

}

?>
