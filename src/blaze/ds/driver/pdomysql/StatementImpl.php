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

    public function __construct(Connection $con, PDO $pdo) {
        parent::__construct($con, $pdo);
    }

    public function executeQuery($sql) {
        $this->checkClosed();
        try {
            $this->reset();
            $this->stmt = $this->pdo->query($sql);
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }

        $this->resultSet = new ResultSetImpl($this, $this->stmt);
        return $this->resultSet;
    }

    public function getResultSet() {
        $this->checkClosed();
        if ($this->stmt == null)
            return null;
        if ($this->resultSet == null)
            $this->resultSet = new ResultSetImpl($this, $this->stmt);
        return $this->resultSet;
    }

}

?>
