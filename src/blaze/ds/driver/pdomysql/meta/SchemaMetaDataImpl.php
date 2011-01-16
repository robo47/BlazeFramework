<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractSchemaMetaData;

/**
 * Description of SchemaMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class SchemaMetaDataImpl extends AbstractSchemaMetaData {

    public function __construct(\blaze\ds\meta\DatabaseMetaData $databaseMetaData, $schemaName) {
        $this->databaseMetaData = $databaseMetaData;
        $this->schemaName = $schemaName;
    }

    public function drop() {
        $this->databaseMetaData->getConnection()->dropDatabase($this->schemaName);
    }

    public function getDatabaseMetaData() {
        return $this->databaseMetaData;
    }

    public function getSchemaName() {
        return $this->schemaName;
    }

    public function getSchemaCharset() {
        $this->checkClosed();
        $charset = null;

        $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
        $stmt->setString(0, $schemaName);
        $stmt->execute();
        $rs = $stmt->getResultSet();

        if ($rs->next())
            $charset = $rs->getString('SCHEMA_CHARSET');

        $stmt->close();
        $rs->close();

        return $charset;
    }

    public function getSchemaCollation() {
        $this->checkClosed();
        $charset = null;

        $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
        $stmt->setString(0, $schemaName);
        $stmt->execute();
        $rs = $stmt->getResultSet();

        if ($rs->next())
            $charset = $rs->getString('SCHEMA_COLLATION');

        $stmt->close();
        $rs->close();

        return $charset;
    }

    public function setSchemaName($schemaName) {
        throw new OperationNotSupportedException('This can cause data loss because of the MySQL implementation, you can use the addDatabase() method to copy a database.');
    }

    public function setSchemaCharset($schemaCharset) {
        $this->checkClosed();
        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('ALTER SCHEMA ' . $this->schemaName . ' CHARACTER SET ' . $schemaCharset);
        $stmt->execute();
        $stmt->close();
        return $this;
    }

    public function setSchemaCollation($schemaCollation) {
        $this->checkClosed();
        $stmt = $this->con->prepareStatement('ALTER SCHEMA ' . $this->schemaName . ' COLLATE ' . $schemaCollation);
        $stmt->execute();
        $stmt->close();
        return $this;
    }

    public function getTables() {
        $tables = array();

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?');
        $stmt->setString(0, $this->schemaName);
        $rs = $stmt->executeQuery();

        while ($rs->next())
            $tables[] = new TableMetaDataImpl($this, $rs->getString('TABLE_NAME'));

        $rs->close();
        $stmt->close();

        return \blaze\collections\Arrays::asList($tables);
    }

    public function getTable($tableName) {
        $table = null;

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
        $stmt->setString(0, $this->schemaName);
        $stmt->setString(1, $tableName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            $table = new TableMetaDataImpl($this, $tableName);

        $rs->close();
        $stmt->close();

        return $table;
    }

    public function getViews() {
        $views = array();

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.VIEWS WHERE TABLE_SCHEMA = ?');
        $stmt->setString(0, $this->schemaName);
        $rs = $stmt->executeQuery();

        while ($rs->next())
            $views[] = new ViewMetaDataImpl($this, $rs->getString('TABLE_NAME'));
        $rs->close();
        $stmt->close();

        return \blaze\collections\Arrays::asList($views);
    }

    public function getView($viewName) {
        $view = null;

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.VIEWS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
        $stmt->setString(0, $this->schemaName);
        $stmt->setString(1, $viewName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            $view = new ViewMetaDataImpl($this, $viewName);
        $rs->close();
        $stmt->close();

        return $view;
    }

    public function getSequences() {
        $sequences = array();

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT col.TABLE_NAME, col.COLUMN_NAME FROM information_schema.TABLES tbl join information_schema.COLUMNS col ON tbl.TABLE_NAME = col.TABLE_NAME WHERE tbl.TABLE_SCHEMA = ? AND col.EXTRA = \'auto_increment\'');
        $stmt->setString(0, $this->schemaName);
        $rs = $stmt->executeQuery();

        while ($rs->next())
            $sequences[] = new SequenceMetaDataImpl($this, $rs->getString(0), $rs->getString(1));
        $rs->close();
        $stmt->close();

        return \blaze\collections\Arrays::asList($sequences);
    }

    public function getSequence($sequenceName) {
        $sequences = null;
        $parts = \blaze\lang\String::asWrapper($sequenceName)->split('_');

        if (count($parts) !== 3)
            throw new \blaze\ds\DataSourceException('Sequencenames in this driver must have the following structure: tablename_columnname_seq');

        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT 1 FROM information_schema.TABLES tbl join information_schema.COLUMNS col ON tbl.TABLE_NAME = col.TABLE_NAME WHERE tbl.TABLE_SCHEMA = ? AND col.EXTRA = \'auto_increment\' AND col.TABLE_NAME = ? AND col.COLUMN_NAME = ?');
        $stmt->setString(0, $this->schemaName);
        $stmt->setString(1, $parts[0]);
        $stmt->setString(2, $parts[1]);
        $rs = $stmt->executeQuery();

        if ($rs->next() && $parts[2] === 'seq')
            $sequence = new SequenceMetaDataImpl($this, $parts[0], $parts[1]);
        $rs->close();
        $stmt->close();

        return $sequence;
    }

    public function addTable(\blaze\ds\meta\TableMetaData $table, $newName = null) {
        $this->checkClosed();
        $table->initialize($this, $newName);
        return $table;
    }

    public function addView(\blaze\ds\meta\ViewMetaData $view, $newName = null) {
        $this->checkClosed();
        if ($newName === null)
            $view = $this->createView($view->getViewName(), $view->getViewDefinition());
        else
            $view = $this->createView($newName, $view->getViewDefinition());

        return $view;
    }

    /**
     * This method does nothing because mysql does not support sequences.
     */
    public function addSequence(\blaze\ds\meta\SequenceMetaData $sequence, $newName = null) {

    }

    public function createTable($tableName, $charset = null, $collation = null, $comment = null) {
        $this->checkClosed();
        return new TableMetaDataImpl(null, $tableName, $comment, $charset, $collation, false);
    }

    public function createView($viewName, $viewDefinition) {
        $this->checkClosed();
        $query = 'CREATE VIEW ' . $viewName . ' AS ' . $viewDefinition;

        $this->databaseMetaData->getConnection()->prepareStatement($query)->executeUpdate();
        return $this->getView($viewName);
    }

    /**
     * This method will always deliver null because mysql does not support sequences.
     */
    public function createSequence($sequenceName, $sequenceType = null, $sequencePrecision = null, $sequenceCurrentValue = null, $sequenceIncrement = null) {
        return null;
    }

    public function dropTable($tableName) {
        $this->checkClosed();
        $this->databaseMetaData->getConnection()->createStatement()->executeUpdate('DROP TABLE ' . $tableName);
    }

    public function dropView($viewName) {
        $this->checkClosed();
        $this->databaseMetaData->getConnection()->createStatement()->executeUpdate('DROP VIEW ' . $viewName);
    }

    public function dropSequence($sequenceName) {
        $this->checkClosed();
        $parts = \blaze\lang\String::asWrapper($sequenceName)->split('_');

        if (count($parts) !== 3)
            throw new \blaze\ds\DataSourceException('Sequencenames in this driver must have the following structure: tablename_columnname_seq');

        $tbl = $this->getTable($parts[0]);
        $col = $tbl->getColumn($parts[1]);
        $this->databaseMetaData
                ->getConnection()
                ->createStatement()
                ->executeUpdate('ALTER TABLE ' . $parts[0] . ' MODIFY COLUMN ' .
                        ColumnMetaDataImpl::getColumnDefinition($col, null, true, true, false));
    }

}

?>
