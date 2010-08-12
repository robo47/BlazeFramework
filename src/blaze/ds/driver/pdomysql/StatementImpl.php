<?php
namespace blaze\ds\driver\pdomysql;
use blaze\lang\Object,
blaze\ds\Connection,
blaze\ds\driver\pdobase\AbstractStatement,
PDO,
\blaze\ds\SQLException;

/**
 * Description of StatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class StatementImpl extends AbstractStatement {


    public function __construct(Connection $con, PDO $pdo) {
        parent::__construct($con, $pdo);
    }
   


    
    
    public function executeQuery($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        try{
            $this->reset();
            $this->stmt = $this->pdo->query($sql);
        }catch(\PDOException $e){
            throw new SQLException($e->getMessage(), $e->getCode());
        }

        $this->resultSet = new ResultSetImpl($this, $this->stmt);
        return $this->resultSet;
    }
    
    
    /**
     * @return blaze\ds\meta\ResultSetMetaData
     */
    public function getMetaData(){
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->rsmd == null)
                $this->rsmd = new \blaze\ds\driver\pdomysql\meta\ResultSetMetaDataImpl($this, $this->stmt);
        return $this->rsmd;
    }
    public function getResultSet() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt == null)
                return null;
        if($this->resultSet == null)
                $this->resultSet = new ResultSetImpl($this, $this->stmt);
        return $this->resultSet;
    }
    
    

    
}

?>
