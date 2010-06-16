<?php
namespace blaze\sql\driver\pdobase;
use blaze\lang\Object,
    blaze\sql\Connection,
    PDO;

/**
 * Description of AbstractConnection
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractConnection extends Object implements Connection {

    /**
     *
     * @var PDO
     */
    private $pdo;
    /**
     *
     * @var string
     */
    private $driver;
    /**
     *
     * @var string
     */
    private $host;
    /**
     *
     * @var integer
     */
    private $port;
    /**
     *
     * @var string
     */
    private $database;
    /**
     *
     * @var string
     */
    private $user;
    /**
     *
     * @var string
     */
    private $password;
    /**
     *
     * @var array
     */
    private $options;

    public function __construct($driver, $host, $port, $database, $user, $password, $options) {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
        $dsn = $driver.':host='.$host.';port='.$port.';dbname='.$database;
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function beginTransaction() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        $this->pdo->beginTransaction();
    }
    public function close() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        $this->pdo = null;
    }
    public function isClosed(){
        return $this->pdo == null;
    }
    public function commit() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        $this->pdo->commit();
    }
    public function createStatement() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return new StatementImpl($this, $this->pdo);
    }
    public function getAutoCommit() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return $this->pdo->getAttribute(PDO::ATTR_AUTOCOMMIT);
    }
    public function getMetaData() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return new DatabaseMetaDataImpl($this, $dsn, $user);
    }
    public function getTransactionIsolation() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return null;
    }
    public function prepareCall($sql) {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return new CallableStatementImpl($this, $sql);
    }
    public function prepareStatement($sql) {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return new PreparedStatementImpl($this, $sql);
    }
    public function rollback() {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        $this->pdo->rollBack();
    }
    public function setAutoCommit($autoCommit) {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
        return $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, $autoCommit);
    }
    public function setTransactionIsolation($level) {
        if($this->isClosed())
                throw new SQLException('Connection is already closed.');
    }

}

?>
