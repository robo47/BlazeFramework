<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\ResultSet,
 blaze\ds\Statement1,
 blaze\lang\String;

/**
 * Description of AbstractResultSet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractResultSet extends Object implements ResultSet {

    /**
     *
     * @var blaze\ds\Statement
     */
    private $stmt;
    /**
     *
     * @var \PDOStatement
     */
    private $pdoStmt;
    /**
     *
     * @var mixed
     */
    private $actRow;
    /**
     * @var mixed
     */
    private $actRowIndex;
    /**
     *
     * @var int
     */
    private $rowNumber;
    /**
     *
     * @var blaze\ds\SQLWarning
     */
    protected $warnings;

    public function __construct(Statement1 $stmt, \PDOStatement $pdoStmt) {
        $this->stmt = $stmt;
        $this->pdoStmt = $pdoStmt;
        $this->rowNumber = 0;
    }

    /**
     * @return boolean
     */
    public function next() {
        $this->checkedClosed();

        $this->actRow = $this->pdoStmt->fetch(\PDO::FETCH_ASSOC);
        $this->actRowIndex = is_array($this->actRow) ? array_values($this->actRow) : $this->actRow;

        if ($this->actRow !== false) {
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

    /**
     * Returns wether the ResultSet is closed or not.
     *
     * @return boolean
     */
    public function isClosed() {
        return $this->stmt == null;
    }

    /**
     * Returns the warnings which from the database
     *
     * @return blaze\ds\SQLWarning
     */
    public function getWarnings() {
        $this->checkedClosed();
        return $this->warnings;
    }

    /**
     *
     * @return blaze\ds\Statement
     */
    public function getStatement() {
        $this->checkedClosed();
        return $this->stmt;
    }

    /**
     *
     * @return int The actual row number
     */
    public function getRow() {
        $this->checkedClosed();
        return $this->rowNumber;
    }

    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function absolute($number) {
        $this->checkedClosed();
        if ($number < $this->rowNumber) {
            return false;
        } else if ($number == $this->rowNumber) {
            return true;
        } else {
            while ($this->next())
                if ($this->rowNumber == $number)
                    return true;
            return false;
        }
    }

    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function relative($count) {
        $this->checkedClosed();
        if ($number < 0) {
            return false;
        } else if ($number == 0) {
            return true;
        } else {
            $target = $this->rowNumber + $count;

            while ($this->next())
                if ($this->rowNumber == $target)
                    return true;
            return false;
        }
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     *
     */
    protected function get($identifier) {
        if (!is_array($this->actRow))
            throw new \blaze\ds\SQLException('No valid result.');
        if (is_int($identifier)) {
            if (!array_key_exists($identifier, $this->actRowIndex))
                throw new \blaze\ds\SQLException('Index ' . $identifier . ' was not found.');
            return $this->actRowIndex[$identifier];
        }else {
            if (!array_key_exists(String::asNative($identifier), $this->actRow))
                throw new \blaze\ds\SQLException('Index ' . $identifier . ' was not found.');
            return $this->actRow[String::asNative($identifier)];
        }
    }

    protected function checkedClosed() {
        if ($this->isClosed())
            throw new \blaze\ds\SQLException('Statement is already closed.');
    }

}
?>
