<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\ds\driver\pdobase\AbstractConnection,
 blaze\ds\driver\pdomysql\meta\DatabaseMetaDataImpl,
 blaze\ds\Connection,
 PDO;

/**
 * Description of ConnectionImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ConnectionImpl extends AbstractConnection {

    public function __construct($driver, $host, $port, $database, $user, $password, $options) {
        parent::__construct($driver, $host, $port, $database, $user, $password, $options);
    }

    public function createStatement($type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new StatementImpl($this, $this->pdo);
    }

    public function getMetaData() {
        $this->checkClosed();
        return new DatabaseMetaDataImpl($this, $this->pdo, $this->host, $this->port, $this->database, $this->user, $this->options);
    }

    /**
     *
     * @todo Implement
     */
    public function getTransactionIsolation() {
        $this->checkClosed();
        try{
            $stm = $this->createStatement();
            $rs = $stm->executeQuery('SELECT @@tx_isolation');
            if($rs->next())
                return $rs->getString(0);
            else
                return null;
        }catch(\PDOException $e){
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function prepareCall($sql, $type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new CallableStatementImpl($this, $this->pdo, $sql);
    }

    public function prepareStatement($sql, $type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new PreparedStatementImpl($this, $this->pdo, $sql);
    }

    /**
     *
     * @todo Implement
     */
    public function setTransactionIsolation($level) {
        $this->checkClosed();
        try{
            $stm = $this->pdo->query('SET SESSION TRANSACTION ISOLATION LEVEL '.$level);
            $stm->execute();
        }catch(\PDOException $e){
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Returns the DatabaseMetaData of the database with the given name
     * @param string|blaze\lang\String $databaseName
     * @return \blaze\ds\meta\DatabaseMetaData Returns the meta data of the database or null if no db with that name was found.
     */
    public function getDatabase($databaseName){
        $this->checkClosed();
        try{
            $con = new self($this->driver, $this->host, $this->port, $databaseName, $this->user, $this->password, array());
            return new DatabaseMetaDataImpl($con, $con->pdo, $con->host, $con->port, $con->database, $con->user, $con->options);
        }catch(\PDOException $e){
            return null;
        }
    }

    public function addDatabase(\blaze\ds\meta\DatabaseMetaData $database, $newName = null) {
        $this->checkClosed();
        if($newName === null)
            $db = $this->createDatabase($database->getDatabaseName(), $database->getDatabaseCharset(), $database->getDatabaseCollation());
        else
            $db = $this->createDatabase($newName, $database->getDatabaseCharset(), $database->getDatabaseCollation());

        foreach($database->getSchemas() as $schema)
            $db->addSchema($schema);
    }

    public function createDatabase($databaseName, $defaultCharset = null, $defaultCollation = null) {
        $query = 'CREATE DATABASE '.$databaseName;

        if($defaultCharset !== null)
            $query .= ' CHARACTER SET '.$defaultCharset;
        if($defaultCollation !== null)
            $query .= ' COLLATE '.$defaultCollation;

        try{
            $this->pdo->query($query);
            $con = new self($this->driver, $this->host, $this->port, $databaseName, $this->user, $this->password, array());
            return new DatabaseMetaDataImpl($con, $con->pdo, $con->host, $con->port, $con->database, $con->user, $con->options);
        }catch(\PDOException $e){
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function dropDatabase($databaseName) {
        $this->checkClosed();
        try{
            $this->pdo->query('DROP DATABASE '.$databaseName);
        }catch(\PDOException $e){
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }


}
?>
