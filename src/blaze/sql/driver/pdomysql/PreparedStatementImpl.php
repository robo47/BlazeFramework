<?php
namespace blaze\sql\driver\pdomysql;
use blaze\lang\Object,
        \blaze\sql\driver\pdobase\AbstractPreparedStatement,
        \blaze\sql\Connection;

/**
 * Description of PreparedStatementImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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
            if(!$this->stmt->execute())
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
      * @return blaze\sql\ResultSet
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
     * @return blaze\sql\meta\ResultSetMetaData
     */
    public function getMetaData(){

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

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\math\BigDecimal $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\sql\type\Blob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBlob($identifier, \blaze\sql\type\Blob $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param boolean $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBoolean($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param integer $value
     * @return blaze\lang\PreparedStatement
     */
    public function setByte($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\sql\Clob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setClob($identifier, \blaze\sql\type\Clob $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDate($identifier, \blaze\util\Date $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param double $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDouble($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param float $value
     * @return blaze\lang\PreparedStatement
     */
    public function setFloat($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param integer $value
     * @return blaze\lang\PreparedStatement
     */
    public function setInt($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param long $value
     * @return blaze\lang\PreparedStatement
     */
    public function setLong($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\sql\type\NClob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNClob($identifier, \blaze\sql\type\NClob $value){

    }
    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNString($identifier, $value){

    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\lang\Object $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNull($identifier){

    }//, $value);
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setString($identifier, $value){

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
    }
    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTimestamp($identifier, \blaze\util\Date $value){
        $str = self::$dateTimeFormatter->format($value);
        $this->set($identifier, $str);
    }
}

?>
