<?php
namespace blaze\ds\driver\pdomysql;
use blaze\lang\Object,
        \blaze\ds\driver\pdobase\AbstractPreparedStatement,
        \blaze\ds\Connection,
        \blaze\ds\SQLException;

/**
 * Description of PreparedStatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class PreparedStatementImpl extends AbstractPreparedStatement implements \blaze\lang\StaticInitialization {

    private $query;

    private static $dateFormatter;
    private static $dateTimeFormatter;
    private static $timeFormatter;

    public static function staticInit(){
        self::$dateFormatter = new \blaze\text\DateFormat('Y-m-d');
        self::$dateTimeFormatter = new \blaze\text\DateFormat('Y-m-d H:i:s');
        self::$timeFormatter = new \blaze\text\DateFormat('H:i:s');
    }

    public function  __construct(Connection $con, \PDO $pdo, $sql) {
        parent::__construct($con, $pdo);
        $this->query = $sql;
        $this->stmt = $this->pdo->prepare($sql);
    }

    /**
     *
     * @return boolean True when the SQL-Statement returned a ResultSet, false if the updateCount was returned or there are no results.
     */
    public function execute(){
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');

        try {
            //$this->reset();
            if($this->stmt->execute() === false)
                   throw new SQLException('Could not execute query.');

            if($this->stmt->columnCount() === 0)
                return false;

            return true;
        }catch(\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }
     /**
      *
      * @return blaze\ds\ResultSet
      */
    public function executeQuery(){
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');

        try {
            //$this->reset();
            if(!$this->stmt->execute())
                throw new SQLException('Could not execute query.');

            if($this->stmt->columnCount() === 0)
                throw new SQLException('Statement has no resultset.');

            return $this->getResultSet();
        }catch(\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
    }
     /**
      *
      * @return integer The count of the updated rows or 0 if there was no return.
      */
    public function executeUpdate(){
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');

        try {
            //$this->reset();
            if(!$this->stmt->execute())
                throw new SQLException('Could not execute query.');

            if($this->stmt->columnCount() !== 0)
                throw new SQLException('Statement has a resultset.');

            return $this->stmt->rowCount();
        }catch(\PDOException $e) {
            throw new SQLException($e->getMessage(), $e->getCode());
        }
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
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param mixed $value
     * @return blaze\lang\PreparedStatement
     */
    private function set($identifier, $value, $type = \PDO::PARAM_STR){
        $this->stmt->bindValue($identifier + 1, $value, $type);
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\ArrayObject $value
     * @return blaze\lang\PreparedStatement
     */
    public function setArray($identifier, \blaze\util\ArrayObject $value){
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
        //return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\math\BigDecimal $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value){
        $this->set($identifier, $value->__toString(),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\ds\type\Blob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBlob($identifier, \blaze\ds\type\Blob $value){
        $buffer = new \blaze\lang\StringBuffer();
        $value->getInputStream()->read($buffer);
        $this->set($identifier, $buffer->__toString(),\PDO::PARAM_LOB);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param boolean $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBoolean($identifier, $value){
        $this->set($identifier, \blaze\lang\Boolean::asNative($value),\PDO::PARAM_BOOL);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param integer $value
     * @return blaze\lang\PreparedStatement
     */
    public function setByte($identifier, $value){
        $this->set($identifier, \blaze\lang\Byte::asNative($value),\PDO::PARAM_INT);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\ds\Clob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setClob($identifier, \blaze\ds\type\Clob $value){
        throw new \blaze\lang\NotYetImplementedException();
        //$this->set($identifier, $value->,\PDO::PARAM_LOB);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDate($identifier, \blaze\util\Date $value){
        $str = self::$dateFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDateTime($identifier, \blaze\util\Date $value){
        $str = self::$dateTimeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param double $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDouble($identifier, $value){
        $this->set($identifier, \blaze\lang\Double::asNative($value),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param float $value
     * @return blaze\lang\PreparedStatement
     */
    public function setFloat($identifier, $value){
        $this->set($identifier, \blaze\lang\Float::asNative($value),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param integer $value
     * @return blaze\lang\PreparedStatement
     */
    public function setInt($identifier, $value){
        $this->set($identifier, \blaze\lang\Integer::asNative($value),\PDO::PARAM_INT);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param long $value
     * @return blaze\lang\PreparedStatement
     */
    public function setLong($identifier, $value){
        $this->set($identifier, \blaze\lang\Long::asNative($value),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\ds\type\NClob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNClob($identifier, \blaze\ds\type\NClob $value){
        throw new \blaze\lang\NotYetImplementedException();
        $this->set($identifier, $value->__toString(),\PDO::PARAM_STR);
        return $this;
    }
    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNString($identifier, $value){
        $this->set($identifier, \blaze\lang\String::asNative($value),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\lang\Object $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNull($identifier){
        $this->set($identifier, null,\PDO::PARAM_NULL);
        return $this;
    }//, $value);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setString($identifier, $value){
        $this->set($identifier, \blaze\lang\String::asNative($value),\PDO::PARAM_STR);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTime($identifier, \blaze\util\Date $value){
        $str = self::$timeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTimestamp($identifier, \blaze\util\Date $value){
        return $this->setDateTime($identifier, $value);
    }
}

?>
