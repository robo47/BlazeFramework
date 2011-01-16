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

    /**
     *
     * @var \blaze\ds\meta\SchemaMetaData
     */
    private $schema;

    public function __construct(\blaze\ds\Connection $con, \PDO $pdo, $host, $port, $database, $username, $options) {
        $this->con = $con;
        $this->pdo = $pdo;
        $this->username = $username;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->options = $options;
        $this->driverName = new \blaze\lang\String('pdomysql');
        $this->driverVersion = new \blaze\lang\String('0.1');
        $this->databaseProductName = new \blaze\lang\String('MySQL');
        $this->databaseProductVersion = new \blaze\lang\String($this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
        $this->schema = $this->getSchema($this->database);
    }

    public function getConnection() {
        return $this->con;
    }

    public function getHost() {
        return $this->host;
    }

    public function getPort() {
        return $this->port;
    }

    public function getOptions() {
        return $this->options;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getDatabaseProductName() {
        return $this->databaseProductName;
    }

    public function getDatabaseProductVersion() {
        return $this->databaseProductVersion;
    }

    public function getDatabaseName() {
        return $this->database;
    }

    public function getDatabaseCharset() {
        return $this->schema->getSchemaCharset();
    }

    public function getDatabaseCollation() {
        return $this->schema->getSchemaCollation();
    }

    public function setDatabaseName($name) {
        $this->schema->setSchemaName($name);
        return $this;
    }

    public function setDatabaseCharset($databaseCharset) {
        $this->schema->setSchemaCharset($databaseCharset);
        return $this;
    }

    public function setDatabaseCollation($databaseCollation) {
        $this->schema->setSchemaCollation($databaseCollation);
        return $this;
    }

    public function getDriverName() {
        return $this->driverName;
    }

    public function getDriverVersion() {
        return $this->driverVersion;
    }

    public function getSchemas() {
        $this->checkClosed();
        $schemas = array();

        $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA');
        $rs = $stmt->executeQuery();

        while ($rs->next())
            $schemas[] = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'));

        $stmt->close();
        $rs->close();

        return \blaze\collections\Arrays::asList($schemas);
    }

    public function getSchema($schemaName) {
        $this->checkClosed();
        $schema = null;

        $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
        $stmt->setString(0, $schemaName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            $schema = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'));
        $stmt->close();
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

    /**
     * Does not create a new schema, instead it delivers the schema object
     * which represents this database. This is because mysql does not support
     * schemas.
     */
    public function createSchema($name, $charset = null, $collation = null) {
        return $this->getSchema($this->database);
    }

    public function drop() {
        $this->checkClosed();
        $this->schema->drop();
    }

    public function dropSchema($schemaName) {
        $this->checkClosed();
        $this->con->dropDatabase($this->database);
    }

    public function addRole($roleName, $password = null) {
        return new RoleMetaDataImpl($this);
    }

    public function getRole($name) {
        return new RoleMetaDataImpl($this);
    }

    public function dropRole($roleName) {

    }

    public function getRoles() {
        return \blaze\collections\Arrays::asList(array(new RoleMetaDataImpl($this)));
    }

    public function addUser($userName, $password) {
        $this->checkClosed();
        $user = null;

        $stmt = $this->con->prepareStatement('CREATE USER ?@\'localhost\' IDENTIFIED BY ?');
        $stmt->setString(0, $userName);
        $stmt->setString(1, $password);
        $stmt->executeUpdate();
        $user = $this->getUser($userName);
        $stmt->close();

        return $user;
    }

    public function getUser($userName = null) {
        if ($userName === null)
            $userName = $this->username;

        $this->checkClosed();
        $user = null;

        $stmt = $this->con->prepareStatement('SELECT * FROM mysql.user WHERE user = ?');
        $stmt->setString(0, $userName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            $user = new UserMetaDataImpl($this, $userName);

        $stmt->close();
        $rs->close();

        return $user;
    }

    public function dropUser($userName) {
        $this->checkClosed();
        $stmt = $this->con->prepareStatement('DROP USER ?');
        $stmt->setString(0, $userName);
        $stmt->executeUpdate();
        $stmt->close();
    }

    public function getUsers() {
        $this->checkClosed();
        $users = array();

        $stmt = $this->con->prepareStatement('SELECT user FROM mysql.user');
        $rs = $stmt->executeQuery();

        while ($rs->next())
            $users[] = new UserMetaDataImpl($this, $rs->getString(0));

        $stmt->close();
        $rs->close();

        return \blaze\collections\Arrays::asList($users);
    }

}

?>
