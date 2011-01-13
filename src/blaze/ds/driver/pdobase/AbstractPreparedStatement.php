<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 \blaze\ds\PreparedStatement,
 \blaze\ds\Connection,
 \blaze\ds\DataSourceException;

/**
 * Description of AbstractPreparedStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractPreparedStatement extends AbstractStatement implements PreparedStatement {

    private $query;
    /**
     *
     * @var \blaze\ds\meta\ResultSetMetaData
     */
    protected $rsmd;

    public function __construct(Connection $con, \PDO $pdo, $query, $type) {
        parent::__construct($con, $pdo, $type);
        $this->query = $query;
        $options = array();

        if ($this->resultSetType === \blaze\ds\ResultSet::TYPE_SCROLL)
            $options[\PDO::ATTR_CURSOR] = \PDO::CURSOR_SCROLL;
        else
            $options[\PDO::ATTR_CURSOR] = \PDO::CURSOR_FWDONLY;

        $this->stmt = $this->pdo->prepare($query, $options);
    }

    /**
     *
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
    public function execute($query = null) {
        $this->checkClosed();

        try {
            //$this->reset();
            if ($this->stmt->execute() === false) {
                throw new DataSourceException('Could not execute query. ' . $this->stmt->errorInfo());
            }

            if ($this->stmt->columnCount() === 0)
                return false;

            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @return int The count of the updated rows or 0 if there was no return.
     */
    public function executeUpdate($query = null) {
        $this->checkClosed();

        try {
            if ($this->stmt->execute() === false) {
                throw new DataSourceException('Could not execute query. ' . $this->stmt->errorInfo());
            }

            if ($this->stmt->columnCount() !== 0)
                throw new DataSourceException('Statement has a resultset.');

            return $this->stmt->rowCount();
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param mixed $value
     * @return blaze\lang\PreparedStatement
     */
    protected function set($identifier, $value, $type = \PDO::PARAM_STR) {
        if (\blaze\lang\String::isType($identifier))
            $this->stmt->bindValue(':' . $identifier, $value, $type); //|\PDO::PARAM_INPUT_OUTPUT);
 else
            $this->stmt->bindValue($identifier + 1, $value, $type); //|\PDO::PARAM_INPUT_OUTPUT);

    }

}

?>
