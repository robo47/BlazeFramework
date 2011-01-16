<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\ds\Connection,
 blaze\ds\driver\pdobase\AbstractStatement,
 PDO,
 \blaze\ds\DataSourceException;

/**
 * Description of StatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class StatementImpl extends AbstractStatement {

    public function __construct(Connection $con, PDO $pdo, $type) {
        parent::__construct($con, $pdo, $type);
    }

    public function executeQuery($query = null) {
        $this->checkClosed();
        if ($query === null)
            throw new \blaze\lang\NullPointerException('Query must not be null!');
        try {
            $this->reset();
            $options = array();

            if ($this->resultSetType === \blaze\ds\ResultSet::TYPE_SCROLL)
                $options[PDO::ATTR_CURSOR] = PDO::CURSOR_SCROLL;
            else
                $options[PDO::ATTR_CURSOR] = PDO::CURSOR_FWDONLY;

            $this->stmt = $this->pdo->prepare($query, $options);
            $this->stmt->execute();
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }

        $this->resultSet = new ResultSetImpl($this, $this->stmt, $this->resultSetType);
        return $this->resultSet;
    }

    public function getResultSet() {
        $this->checkClosed();
        if ($this->stmt == null)
            return null;
        if ($this->resultSet == null)
            $this->resultSet = new ResultSetImpl($this, $this->stmt, $this->resultSetType);
        return $this->resultSet;
    }

}

?>
