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
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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

    public function __construct($driver, $host, $port, $database, $user, $password, $options) {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
        $dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database;
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function beginTransaction() {
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

    public function commit() {
        $this->checkClosed();
        $this->pdo->commit();
    }

    public function getAutoCommit() {
        $this->checkClosed();
        return $this->pdo->getAttribute(PDO::ATTR_AUTOCOMMIT);
    }

    /**
     *
     * @todo Implement
     */
    public function getTransactionIsolation() {
        $this->checkClosed();
        return null;
    }

    public function rollback() {
        $this->checkClosed();
        $this->pdo->rollBack();
    }

    public function setAutoCommit($autoCommit) {
        $this->checkClosed();
        return $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, $autoCommit);
    }

    /**
     *
     * @todo Implement
     */
    public function setTransactionIsolation($level) {
        $this->checkClosed();
    }

    protected function checkClosed() {
        if ($this->isClosed())
            throw new SQLException('Connection is already closed.');
    }

}
?>
