<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\Connection,
 blaze\ds\Statement1,
 PDO;

/**
 * Description of AbstractStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractStatement1 extends Object implements Statement1 {

    /**
     *
     * @var blaze\ds\Connection
     */
    protected $con;
    /**
     *
     * @var PDO
     */
    protected $pdo;
    /**
     *
     * @var PDOStatement
     */
    protected $stmt;
    /**
     *
     * @var blaze\ds\meta\ResultSetMetaData
     */
    protected $rsmd;
    /**
     *
     * @var blaze\ds\ResultSet
     */
    protected $resultSet;
    /**
     *
     * @var array[blaze\ds\DataSourceWarning]
     */
    protected $warnings = array();
    /**
     *
     * @var string
     */
    protected $batch = '';
    /**
     *
     * @var int
     */
    protected $timeout = 0;
    /**
     *
     * @var int
     */
    protected $updateCount = -1;

    public function __construct(Connection $con, PDO $pdo) {
        $this->con = $con;
        $this->pdo = $pdo;
    }

    public function addBatch($sql) {
        $this->checkClosed();
        $this->batch .= $sql;
    }

    public function clearBatch() {
        $this->checkClosed();
        $this->batch = '';
    }

    public function close() {
        $this->checkClosed();
        if ($this->stmt != null)
            $this->stmt->closeCursor();
        $this->reset();
        $this->pdo = null;
    }

    public function executeBatch() {
        $this->checkClosed();
        $results = array();
        try {
            $this->reset();
            $autoCom = $this->con->getAutoCommit();
            $queries = explode(';', $this->batch);
            $results = array();

            $this->con->setAutoCommit(false);
            $this->con->beginTransaction();

            foreach ($queries as $query) {
                if (strlen($query) > 0) {
                    $res = $this->pdo->query($query);

                    if ($res !== false && $res->columnCount() == 0)
                        $results[] = $res->rowCount();
                    else
                        throw new \blaze\ds\BatchUpdateException('Query returned result: ' . $query);
                }
            }

            $this->con->commit();
            $this->con->setAutoCommit($autoCom);
        } catch (\PDOException $e) {
            $this->con->setAutoCommit($autoCom);
            $this->con->rollback();
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }

        $this->batch = '';
        return $results;
    }

    public function getConnection() {
        $this->checkClosed();
        return $this->con;
    }

    public function getUpdateCount() {
        $this->checkClosed();
        return $this->updateCount;
    }

    public function getWarnings() {
        $this->checkClosed();
        return $this->warnings;
    }

    public function isClosed() {
        return $this->pdo == null;
    }

    public function getQueryTimeout() {
        return $this->timeout;
    }

    public function setQueryTimeout($seconds) {
        $this->timeout = $seconds;
    }

    protected function reset() {
        if ($this->stmt != null)
            $this->stmt->closeCursor();
        $this->stmt = null;
        $this->rsmd = null;
        $this->resultSet = null;
        $this->updateCount = -1;
    }

    protected function checkClosed() {
        if ($this->isClosed())
            throw new \blaze\ds\DataSourceException('Statement is already closed.');
    }

}

?>
