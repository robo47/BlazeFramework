<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 \blaze\ds\CallableStatement,
 \blaze\ds\Connection,
 \PDO,
 \blaze\ds\DataSourceException;

/**
 * Description of AbstractCallableStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractCallableStatement extends AbstractPreparedStatement implements \blaze\ds\CallableStatement {

    protected $registeredOutParam = array();

    public function __construct(Connection $con, \PDO $pdo, $sql) {
        parent::__construct($con, $pdo, $sql);
    }

    public function set($identifier, $value, $type =\PDO::PARAM_STR) {
        return parent::set($identifier, $value, $type);
    }

    protected function get($identifier) {
        if (!is_array($this->actRow))
            throw new DataSourceException('No valid result.');
        if (is_int($identifier)) {
            if (!array_key_exists($identifier, $this->actRowIndex))
                throw new DataSourceException('Index ' . $identifier . ' was not found.');
            return $this->actRowIndex[$identifier];
        }else {
            if (!array_key_exists(String::asNative($identifier), $this->actRow))
                throw new DataSourceException('Index ' . $identifier . ' was not found.');
            return $this->actRow[String::asNative($identifier)];
        }
    }

    public function execute() {
        $this->checkClosed();

        try {
            //$this->reset();
            if ($this->stmt->execute() === false)
                throw new DataSourceException('Could not execute query.');

            if ($this->stmt->columnCount() === 0)
                return false;

            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }
    }

}

?>
