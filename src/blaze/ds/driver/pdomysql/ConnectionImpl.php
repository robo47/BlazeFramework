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

    public function __construct($driver, $host, $port, $database, $user, $password, \blaze\collections\map\Properties $options = null) {
        parent::__construct($driver, $host, $port, $database, $user, $password, $options);
    }

    private function getTransactionName($level){
        switch($level){
            case Connection::TRANSACTION_READ_COMMITTED:
                return 'READ COMMITTED';
            case Connection::TRANSACTION_READ_UNCOMMITTED:
                return 'READ UNCOMMITTED';
            case Connection::TRANSACTION_REPEATABLE_READ:
                return 'REPEATABLE READ';
            case Connection::TRANSACTION_SERIALIZABLE:
                return 'SERIALIZABLE';
        }
    }

    public function createStatement($type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new StatementImpl($this, $this->pdo, $type);
    }

    public function getMetaData() {
        $this->checkClosed();
        return new DatabaseMetaDataImpl($this, $this->pdo, $this->host, $this->port, $this->database, $this->user, $this->options);
    }

    public function createBlob(){
        return new type\BlobImpl(null);
    }

    public function createClob(){
        return new type\ClobImpl(null);
    }

    public function createNClob(){
        return new type\NClobImpl(null);
    }

    public function prepareCall($query, $type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new CallableStatementImpl($this, $this->pdo, $query, $type);
    }

    public function prepareStatement($query, $type = \blaze\ds\ResultSet::TYPE_FORWARD_ONLY) {
        $this->checkClosed();
        return new PreparedStatementImpl($this, $this->pdo, $query, $type);
    }

    public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED) {
        $this->checkClosed();
        $this->transactionNestingLevel++;

        if($this->transactionNestingLevel === 1){
            $this->pdo->beginTransaction();
        }else{
            $this->setSavepoint();
        }

        $this->setTransactionIsolation($isolationLevel);
    }
    
    protected function getNestedTransactionSavepointName(){
        return 'BDSC_SAVEPOINT_'.$this->transactionNestingLevel;
    }

    public function rollback(\blaze\ds\Savepoint $savepoint = null) {
        $this->checkClosed();
        if($this->transactionNestingLevel === 0)
                throw new \blaze\ds\DataSourceException('No active transaction');

        if($savepoint !== null){
            $this->prepareStatement('ROLLBACK TO SAVEPOINT '.$savepoint->getSavepointName())->executeUpdate();
        }else{
            if($this->transactionNestingLevel === 1){
                $this->transactionNestingLevel = 0;
                $this->pdo->rollBack();
            }else{
                $this->prepareStatement('ROLLBACK TO SAVEPOINT '.$this->getNestedTransactionSavepointName())->executeUpdate();
                $this->transactionNestingLevel--;
            }
        }
    }

    public function commit() {
        $this->checkClosed();

        if($this->transactionNestingLevel === 1){
            $this->pdo->commit();
        }else{
            $this->releaseSavepoint(new SavepointImpl(null, $this->getNestedTransactionSavepointName()));
        }

        $this->transactionNestingLevel--;
    }

    public function setTransactionIsolation($isolationLevel = Connection::TRANSACTION_READ_COMMITTED) {
        $this->checkClosed();
        $this->transactionIsolationLevel = $isolationLevel;
        $this->prepareStatement('SET SESSION TRANSACTION ISOLATION LEVEL ' . $this->getTransactionName($isolationLevel))->executeUpdate();
    }

    public function getTransactionIsolation() {
        $this->checkClosed();
        return $this->transactionIsolationLevel;
    }

    public function releaseSavepoint(\blaze\ds\Savepoint $savepoint){
        $this->prepareStatement('RELEASE SAVEPOINT '.$savepoint->getSavepointName())->executeUpdate();
    }

    public function setSavepoint($name = null){
        if($name === null)
            $name = $this->getNestedTransactionSavepointName();
        $this->prepareStatement('SAVEPOINT '.$name)->executeUpdate();
                return new SavepointImpl($name, $name);
    }

    public function getTransactionNestingLevel() {
        return $this->transactionNestingLevel;
    }

    public function isTransactionActive() {
        return $this->transactionNestingLevel !== 0;
    }

    public function getDatabases() {
        $rs = $this->prepareStatement('SHOW DATABASES')->executeQuery();
        $list = new \blaze\collections\lists\ArrayList();

        while($rs->next())
                $list->add($this->getDatabase($rs->getString(0)));

        return $list;
    }

    public function getDatabase($databaseName) {
        $this->checkClosed();
        try {
            $con = new self($this->driver, $this->host, $this->port, $databaseName, $this->user, $this->password, array());
            return new DatabaseMetaDataImpl($con, $con->pdo, $con->host, $con->port, $con->database, $con->user, $con->options);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function addDatabase(\blaze\ds\meta\DatabaseMetaData $database, $newName = null) {
        $this->checkClosed();
        if ($newName === null)
            $db = $this->createDatabase($database->getDatabaseName(), $database->getDatabaseCharset(), $database->getDatabaseCollation());
        else
            $db = $this->createDatabase($newName, $database->getDatabaseCharset(), $database->getDatabaseCollation());

        foreach ($database->getSchemas() as $schema)
            $db->addSchema($schema);
    }

    public function createDatabase($databaseName, $defaultCharset = null, $defaultCollation = null) {
        $query = 'CREATE DATABASE ' . $databaseName;

        if ($defaultCharset !== null)
            $query .= ' CHARACTER SET ' . $defaultCharset;
        if ($defaultCollation !== null)
            $query .= ' COLLATE ' . $defaultCollation;

        try {
            $this->prepareStatement($query)->executeUpdate();
            $con = new self($this->driver, $this->host, $this->port, $databaseName, $this->user, $this->password, null);
            return new DatabaseMetaDataImpl($con, $con->pdo, $con->host, $con->port, $con->database, $con->user, $con->options);
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function dropDatabase($databaseName) {
        $this->checkClosed();
        try {
            $this->prepareStatement('DROP DATABASE ' . $databaseName)->executeUpdate();
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

}

?>
