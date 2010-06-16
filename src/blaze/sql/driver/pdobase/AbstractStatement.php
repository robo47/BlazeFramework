<?php
namespace blaze\sql\driver\pdobase;
use blaze\lang\Object,
blaze\sql\Connection,
blaze\sql\Statement,
PDO;

/**
 * Description of AbstractStatement
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractStatement extends Object implements Statement {

    /**
     *
     * @var blaze\sql\Connection
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
     * @var blaze\sql\ResultSet
     */
    protected $resultSet;
    /**
     *
     * @var array[blaze\sql\SQLWarning]
     */
    protected $warnings = array();

    /**
     *
     * @var string
     */
    protected $batch = '';

    public function __construct(Connection $con, PDO $pdo) {
        $this->con = $con;
        $this->pdo = $pdo;
    }
    public function addBatch($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        $this->batch .= $sql;
    }
    public function clearBatch() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        $this->batch = '';
    }
    public function close() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = null;
        $this->resultSet = null;
        $this->pdo = null;
    }
    public function execute($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->query($sql);
    }
    public function executeBatch() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        try {
            if($this->stmt != null)
                $this->stmt->closeCursor();
            $autoCom = $this->con->getAutoCommit();
            $queries = explode(';',$this->batch);
            $results = array();

            $this->con->setAutoCommit(false);
            $this->con->beginTransaction();

            foreach($queries as $query) {
                if(strlen($query) > 0) {
                    $results[] = $this->pdo->query($query);
                    var_dump($this->pdo->errorInfo());
                }
            }

            $this->con->commit();
            $this->con->setAutoCommit($autoCom);
        }catch(\PDOException $e) {
            $this->con->setAutoCommit($autoCom);
            $this->con->rollback();
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }
    public function executeQuery($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->query($sql);
    }
    public function executeUpdate($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->exec($sql);
    }
    public function getConnection() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->con;
    }
    public function getResultSet() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->resultSet;
    }
    public function getUpdateCount() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->stmt->rowCount();
    }
    public function getWarnings() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->warnings;
    }
    public function isClosed() {
        return $this->pdo == null;
    }


}

?>
