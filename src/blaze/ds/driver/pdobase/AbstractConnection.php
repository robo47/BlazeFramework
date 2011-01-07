<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\Connection,
 PDO;

/**
 * Description of AbstractConnection
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractConnection extends Object implements Connection {

    /**
     *
     * @var PDO
     */
    public $pdo;
    /**
     *
     * @var string
     */
    protected $driver;
    /**
     *
     * @var string
     */
    protected $host;
    /**
     *
     * @var int
     */
    protected $port;
    /**
     *
     * @var string
     */
    protected $database;
    /**
     *
     * @var string
     */
    protected $user;
    /**
     *
     * @var string
     */
    protected $password;
    /**
     *
     * @var array
     */
    protected $options;
    /**
     *
     * @var blaze\ds\DataSourceWarning
     */
    protected $warnings;

    public function __construct($driver, $host, $port, $database, $user, $password, \blaze\collections\map\Properties $options = null) {
        $opts = array();

        if ($options !== null){
            $timeout = $options->remove('timeout');

            if($timeout !== null && $timeout > 0)
                $opts[PDO::ATTR_TIMEOUT] = $timeout;

            foreach($options as $key => $value)
                $opts[$key] = $value;
        }

        $opts[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
        $dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database;

        try {
            $this->pdo = new PDO($dsn, $user, $password, $opts);
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function __sleep() {
        $arr = array_keys(get_class_vars($this->getClass()->getName()->toNative()));
        $key = array_search('pdo', $arr);
        if ($key !== false)
            unset($arr[$key]);
        return $arr;
    }

    public function __wakeup() {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password, $this->options);
    }

    public function getWarnings() {
        $this->checkClosed();
        return $this->warnings;
    }

    public function clearWarnings() {
        $this->warnings = null;
    }

    public function beginTransaction($isolationLevel = Connection::TRANSACTION_READ_COMMITTED, $name = null) {
        $this->checkClosed();
        $this->pdo->beginTransaction();
    }

    public function close() {
        $this->checkClosed();
        $this->pdo = null;
    }

    public function isClosed() {
        return $this->pdo == null;
    }

    public function commit($name = null) {
        $this->checkClosed();
        $this->pdo->commit();
    }

    public function getAutoCommit() {
        $this->checkClosed();
        return $this->pdo->getAttribute(PDO::ATTR_AUTOCOMMIT);
    }

    /**
     * Returns the Transaction isolation
     * @return int
     */
    public function getTransactionIsolation() {
        $this->checkClosed();
        return Connection::TRANSACTION_NONE;
    }

    public function rollback($name = null) {
        $this->checkClosed();
        $this->pdo->rollBack();
    }

    public function setAutoCommit($autoCommit) {
        $this->checkClosed();
        return $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, $autoCommit);
    }

    public function createOrGetDatabase($databaseName, $defaultCharset = null, $defaultCollation = null) {
        try {
            return $this->createDatabase($databaseName, $defaultCharset, $defaultCollation);
        } catch (\blaze\ds\DataSourceException $e) {
            return $this->getDatabase($databaseName);
        }
    }

    public function dropDatabaseIfExists($databaseName) {
        try {
            $this->dropDatabase($databaseName);
        } catch (\blaze\ds\DataSourceException $e) {

        }
    }

    public function createOrReplaceDatabase($databaseName, $defaultCharset = null, $defaultCollation = null) {
        $this->dropDatabaseIfExists($databaseName);
        return $this->createDatabase($databaseName, $defaultCharset, $defaultCollation);
    }

    protected function checkClosed() {
        if ($this->isClosed())
            throw new DataSourceException('Connection is already closed.');
    }

}

?>
