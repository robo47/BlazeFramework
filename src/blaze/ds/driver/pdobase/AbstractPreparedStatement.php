<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 \blaze\ds\PreparedStatement,
 \blaze\ds\Connection,
 \blaze\ds\SQLException;

/**
 * Description of AbstractPreparedStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractPreparedStatement extends AbstractStatement1 implements PreparedStatement {

    private $query;

    public function __construct(Connection $con, \PDO $pdo, $sql) {
        parent::__construct($con, $pdo);
        $this->query = $sql;
        $this->stmt = $this->pdo->prepare($sql);
    }

    /**
     *
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
    public function execute() {
        $this->checkclosed();

        try {
            //$this->reset();
            if ($this->stmt->execute() === false)
                throw new SQLException('Could not execute query.');

            if ($this->stmt->columnCount() === 0)
                return false;

            return true;
        } catch (\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @return blaze\ds\ResultSet
     */
    public function executeQuery() {
        $this->checkclosed();

        try {
            //$this->reset();
            if (!$this->stmt->execute())
                throw new SQLException('Could not execute query.');

            if ($this->stmt->columnCount() === 0)
                throw new SQLException('Statement has no resultset.');

            return $this->getResultSet();
        } catch (\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @return integer The count of the updated rows or 0 if there was no return.
     */
    public function executeUpdate() {
        $this->checkclosed();

        try {
            //$this->reset();
            if (!$this->stmt->execute())
                throw new SQLException('Could not execute query.');

            if ($this->stmt->columnCount() !== 0)
                throw new SQLException('Statement has a resultset.');

            return $this->stmt->rowCount();
        } catch (\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param mixed $value
     * @return blaze\lang\PreparedStatement
     */
    protected function set($identifier, $value, $type = \PDO::PARAM_STR) {
        $this->stmt->bindValue($identifier + 1, $value, $type);
    }

}
?>
