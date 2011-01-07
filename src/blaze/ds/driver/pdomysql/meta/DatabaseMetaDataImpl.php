<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\lang\Object,
 blaze\ds\driver\pdobase\meta\AbstractDatabaseMetaData;

/**
 * Description of DatabaseMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class DatabaseMetaDataImpl extends AbstractDatabaseMetaData {

    public function __construct(\blaze\ds\Connection $con, \PDO $pdo, $host, $port, $database, $user, $options) {
        $this->con = $con;
        $this->pdo = $pdo;
        $this->user = $user;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->options = $options;
        $this->driverName = new \blaze\lang\String('pdomysql');
        $this->driverVersion = new \blaze\lang\String('0.1');
        $this->databaseProductName = new \blaze\lang\String('MySQL');
        $this->databaseProductVersion = new \blaze\lang\String($this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
        $schema = $this->getSchema($this->database);
        $this->databaseCharset = $schema->getSchemaCharset();
        $this->databaseCollation = $schema->getSchemaCollation();
    }

    /**
     * @return blaze\ds\Connection
     */
    public function getConnection() {
        return $this->con;
    }

    /**
     * @return blaze\lang\String
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @return blaze\lang\String
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseName() {
        return $this->database;
    }

    /**
     * @return blaze\lang\String
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductName() {
        return $this->databaseProductName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductVersion() {
        return $this->databaseProductVersion;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseCharset() {
        return $this->databaseCharset;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseCollation() {
        return $this->databaseCollation;
    }

    /**
     * @return blaze\lang\String
     */
    public function setDatabaseCharset($databaseCharset) {
        $this->checkClosed();
        $query = 'ALTER DATABASE ' . $this->database . ' CHARACTER SET ' . $databaseCharset;

        try {
            $this->pdo->query($query);
            $this->databaseCharset = $databaseCharset;
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * @return blaze\lang\String
     */
    public function setDatabaseCollation($databaseCollation) {
        $this->checkClosed();
        $query = 'ALTER DATABASE ' . $this->database . ' COLLATE ' . $databaseCollation;

        try {
            $this->pdo->query($query);
            $this->databaseCollation = $databaseCollation;
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * @return blaze\lang\String
     */
    public function getDriverName() {
        return $this->driverName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDriverVersion() {
        return $this->driverVersion;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\SchemaMetaData]
     */
    public function getSchemas() {
        $this->checkClosed();
        $stmt = null;
        $rs = null;
        $schemas = array();

        try {
            $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA');
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $schemas[] = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'),
                                $rs->getString('DEFAULT_CHARACTER_SET_NAME'),
                                $rs->getString('DEFAULT_COLLATION_NAME'));
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $schemas;
    }

    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema($schemaName) {
        $this->checkClosed();
        $stmt = null;
        $rs = null;
        $schema = null;

        try {
            $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
            $stmt->setString(0, $schemaName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if ($rs->next())
                $schema = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'),
                                $rs->getString('DEFAULT_CHARACTER_SET_NAME'),
                                $rs->getString('DEFAULT_COLLATION_NAME'));
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $schema;
    }

    public function addSchema(\blaze\ds\meta\SchemaMetaData $schema, $newName = null) {
        $this->checkClosed();
        $dbSchema = $this->getSchema($this->database);

        foreach ($schema->getTables() as $table)
            $dbSchema->addTable($table);
        foreach ($schema->getViews() as $view)
            $dbSchema->addView($view);
    }

    public function createSchema($name, $charset = null, $collation = null) {
        return $this->getSchema($this->database);
    }

    public function drop() {
        $this->checkClosed();
        $this->con->dropDatabase($this->database);
    }

    public function dropSchema($schemaName) {
        $this->checkClosed();
        $this->con->dropDatabase($this->database);
    }

    public function setDatabaseName($name) {
        throw new OperationNotSupportedException('This can cause data loss because of the MySQL implementation, you can use the addDatabase() method to copy a database.');
    }

}

?>
