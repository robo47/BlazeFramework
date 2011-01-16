<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\ResultSet,
 blaze\ds\Statement,
 blaze\lang\String;

/**
 * Description of AbstractResultSet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractResultSet extends Object implements ResultSet {

    /**
     *
     * @var blaze\ds\Statement
     */
    protected $stmt;
    /**
     *
     * @var \PDOStatement
     */
    protected $pdoStmt;
    /**
     *
     * @var array
     */
    protected $actRow;
    /**
     * Specifies wether the column have been bound or not.
     * @var boolean
     */
    protected $columnsBound = false;
    /**
     * @var array
     */
    protected $actRowIndex;
    /**
     *
     * @var int
     */
    protected $rowNumber;
    /**
     *
     * @var int
     */
    protected $type;
    /**
     *
     * @var blaze\ds\DataSourceWarning
     */
    protected $warnings;

    public function __construct(Statement $stmt, \PDOStatement $pdoStmt, $type) {
        $this->stmt = $stmt;
        $this->pdoStmt = $pdoStmt;
        $this->rowNumber = 0;
        $this->type = $type;
    }

    protected function bindColumns(){
        if(!$this->columnsBound){
            $this->columnsBound = true;
            $this->actRow = array();
            $this->actRowIndex = array();
            $count = $this->pdoStmt->columnCount();

            for($i = 0; $i < $count; $i++){
                $meta = $this->pdoStmt->getColumnMeta($i);

                if(array_key_exists('native_type',$meta) && $meta['native_type'] == 'BLOB')
                    $this->pdoStmt->bindColumn(($i + 1), $this->actRow[$meta['name']], \PDO::PARAM_LOB);
                else
                    $this->pdoStmt->bindColumn(($i + 1), $this->actRow[$meta['name']]);

                $this->actRowIndex[$i] = &$this->actRow[$meta['name']];
            }
        }
    }

    /**
     * @return boolean
     * @todo    check if LOB works with PHP 5.3.4+
     */
    public function next() {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_NEXT) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    /**
     * Closes the ResultSet
     */
    public function close() {
        if (!$this->isClosed())
            $this->stmt = null;
    }

    public function getCursorName() {
        $this->checkClosed();
        return String::asWrapper($this->pdoStmt->getAttribute(\PDO::ATTR_CURSOR_NAME));
    }

    /**
     * Returns wether the ResultSet is closed or not.
     *
     * @return boolean
     */
    public function isClosed() {
        return $this->stmt == null;
    }

    public function getWarnings() {
        $this->checkClosed();
        return $this->warnings;
    }

    public function clearWarnings() {
        $this->warnings = null;
    }

    public function getStatement() {
        $this->checkClosed();
        return $this->stmt;
    }

    public function getRow() {
        $this->checkClosed();
        return $this->rowNumber;
    }

    public function getType() {
        return $this->type;
    }

    public function first() {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_FIRST) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    public function last() {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_LAST) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    public function previous() {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_PRIOR) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    public function absolute($number) {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_ABS, $number) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    public function relative($count) {
        $this->checkClosed();
        $this->bindColumns();

        if ($this->pdoStmt->fetch(\PDO::FETCH_BOUND, \PDO::FETCH_ORI_REL, $count) !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     *
     */
    protected function get($identifier) {
        if (!is_array($this->actRow))
            throw new \blaze\ds\DataSourceException('No valid result.');
        if (is_int($identifier)) {
            if (!array_key_exists($identifier, $this->actRowIndex))
                throw new \blaze\ds\DataSourceException('Index ' . $identifier . ' was not found.');
            return $this->actRowIndex[$identifier];
        }else {
            if (!array_key_exists(String::asNative($identifier), $this->actRow))
                throw new \blaze\ds\DataSourceException('Index ' . $identifier . ' was not found.');
            return $this->actRow[String::asNative($identifier)];
        }
    }

    protected function checkClosed() {
        if ($this->isClosed())
            throw new \blaze\ds\DataSourceException('ResultSet is already closed.');
    }

}

?>
