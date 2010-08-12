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
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
     * @var array[blaze\ds\SQLWarning]
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
        $this->reset();
        $this->pdo = null;
    }
    
    public function executeBatch() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        try {
            $this->reset();
            $autoCom = $this->con->getAutoCommit();
            $queries = explode(';',$this->batch);
            $results = array();

            $this->con->setAutoCommit(false);
            $this->con->beginTransaction();

            foreach($queries as $query) {
                if(strlen($query) > 0) {
                    $results[] = $this->pdo->query($query);
                }
            }

            $this->con->commit();
            $this->con->setAutoCommit($autoCom);
        }catch(\PDOException $e) {
            $this->con->setAutoCommit($autoCom);
            $this->con->rollback();
            throw new SQLException($e->getMessage(), $e->getCode());
        }

        $this->batch = '';
    }
    public function getConnection() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->con;
    }
   
    public function getUpdateCount() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');

        if($this->updateCount == 0 && $this->stmt != null)
                return $this->stmt->rowCount();
        return $this->updateCount;
    }
    public function getWarnings() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->warnings;
    }
    public function isClosed() {
        return $this->pdo == null;
    }

    protected function reset(){
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = null;
        $this->rsmd = null;
        $this->resultSet = null;
        $this->updateCount = 0;
    }

}

?>
