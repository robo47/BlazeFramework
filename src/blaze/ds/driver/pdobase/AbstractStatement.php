<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\Connection,
 blaze\ds\Statement,
 PDO;

/**
 * Description of AbstractStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractStatement extends AbstractStatement1 implements Statement {

    public function execute($sql) {
        $this->checkClosed();

        try {
            $this->reset();
            $this->stmt = $this->pdo->query($sql);

            if ($this->stmt !== false && $this->stmt->columnCount() == 0){
                $this->stmt = null;
                return false;
            }
            
            return true;
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode());
        }
    }

    public function executeUpdate($sql) {
        $this->checkClosed();

        $result = 0;

        try {
            $this->reset();
            $result = $this->pdo->query($sql);

            if ($result !== false && $result->columnCount() === 0){
                    $this->updateCount = $result->rowCount();
                    return $this->updateCount;
            }
            throw new \blaze\ds\DataSourceException('No select statements allowed, please use execute() or executeQuery().');
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

}
?>
