<?php
namespace blaze\sql\driver\pdomysql;
use blaze\lang\Object,
blaze\lang\String,
blaze\lang\Boolean,
blaze\lang\Byte,
blaze\lang\Integer,
blaze\util\ArrayObject,
blaze\math\BigDecimal,
blaze\sql\driver\pdobase\AbstractResultSet,
blaze\sql\Statement,
blaze\sql\driver\pdomysql\BlobImpl,
blaze\sql\driver\pdomysql\ClobImpl,
blaze\sql\driver\pdomysql\NClobImpl;

/**
 * Description of ResultSetImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ResultSetImpl extends AbstractResultSet {

    /**
     *
     * @var blaze\sql\Statement
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
     * @var integer
     */
    private $rowNumber;
    /**
     *
     * @var blaze\sql\SQLWarning
     */
    protected $warnings;

    public function __construct(Statement $stmt, \PDOStatement $pdoStmt) {
        $this->stmt = $stmt;
        $this->pdoStmt = $pdoStmt;
        $this->rowNumber = 0;
    }


    /**
     * @return boolean
     */
    public function next() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        $this->actRow = $this->pdoStmt->fetch(\PDO::FETCH_ASSOC);
        $this->actRowIndex = is_array($this->actRow) ? array_values($this->actRow) : $this->actRow;

        if($this->actRow !== false) {
            $this->rowNumber++;
            return true;
        }

        return false;
    }

    /**
     * Closes the ResultSet
     */
    public function close() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
            $this->stmt->close();
        //$this->reset();
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
     * @return blaze\sql\SQLWarning
     */
    public function getWarnings() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->warnings;
    }

    /**
     *
     * @return blaze\sql\Statement
     */
    public function getStatement() {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        return $this->stmt;
    }

    /**
     *
     * @return integer The actual row number
     */
    public function getRow() {
        return $this->rowNumber;
    }

    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function absolute($number) {
        if($number < $this->rowNumber) {
            return false;
        }else if($number == $this->rowNumber) {
            return true;
        }else {
            while($this->next())
                if($this->rowNumber == $number)
                    return true;
            return false;
        }
    }

    /**
     *
     * @return boolean True if the cursor was moved to the new position and false if not
     */
    public function relative($count) {
        if($number < 0) {
            return false;
        }else if($number == 0) {
            return true;
        }else {
            $target = $this->rowNumber + $count;

            while($this->next())
                if($this->rowNumber == $target)
                    return true;
            return false;
        }
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     *
     */
    private function get($identifier) {
        if(!is_array($this->actRow))
            throw new SQLException('No valid result.');
        if(is_int($identifier)) {
            return $this->actRowIndex[$identifier];
        }else {
            return $this->actRow[String::asNative($identifier)];
        }
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\ArrayObject
     */
    public function getArray($identifier) {
        $a = new ArrayObject();
        
        return $a;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\math\BigDecimal
     */
    public function getDecimal($identifier){
        $d = new BigDecimal();

        return $d;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\sql\type\Blob
     */
    public function getBlob($identifier){
        $b = new BlobImpl();

        return $b;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return boolean
     */
    public function getBoolean($identifier){
        return Integer::parseInt($this->get($identifier)) == 1;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
     */
    public function getByte($identifier){
        return Byte::parseByte($this->get($identifier));
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\sql\Clob
     */
    public function getClob($identifier){
        $c = new ClobImpl();

        return $c;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return double
     */
    public function getDouble($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return float
     */
    public function getFloat($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
     */
    public function getInt($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return long
     */
    public function getLong($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\sql\type\NClob
     */
    public function getNClob($identifier){
        $n = new NClobImpl();

        return $n;
    }

    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\lang\String
     */
    public function getNString($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\lang\String
     */
    public function getString($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getTime($identifier){}

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier){}

}

?>
