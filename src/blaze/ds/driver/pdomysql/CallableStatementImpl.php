<?php
namespace blaze\ds\driver\pdomysql;
use  blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\Boolean,
 blaze\lang\Long,
 blaze\lang\Float,
 blaze\lang\Byte,
 blaze\lang\Integer,
 blaze\lang\Double,
 blaze\math\BigDecimal,
 blaze\ds\Statement1,
 blaze\ds\DataSourceException,
 blaze\ds\driver\pdobase\AbstractResultSet,
 blaze\ds\driver\pdomysql\type\BlobImpl,
 blaze\ds\driver\pdomysql\type\ClobImpl,
 blaze\ds\driver\pdomysql\type\NClobImpl,
        \blaze\ds\driver\pdobase\AbstractCallableStatement,
        \blaze\ds\Connection,
        \blaze\ds\CallableStatement,
       \blaze\ds\driver\pdobase\AbstractStatement1;

/**
 * Description of CallableStatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CallableStatementImpl extends AbstractCallableStatement implements \blaze\lang\StaticInitialization {

    private static $dateFormatter;
    private static $dateTimeFormatter;
    private static $timeFormatter;

    public static function staticInit() {
        self::$dateFormatter = new \blaze\text\DateFormat('Y-m-d');
        self::$dateTimeFormatter = new \blaze\text\DateFormat('Y-m-d H:i:s');
        self::$timeFormatter = new \blaze\text\DateFormat('H:i:s');
    }

    public function  __construct(Connection $con, \PDO $pdo, $sql){
        parent::__construct($con, $pdo, $sql);

    }
    
    public function getMetaData() {
        $this->checkclosed();
        if ($this->rsmd == null)
            $this->rsmd = new \blaze\ds\driver\pdomysql\meta\ResultSetMetaDataImpl($this, $this->stmt);

        return $this->rsmd;
    }

    public function getResultSet() {
        $this->checkclosed();
        if ($this->stmt == null)
            return null;
        if ($this->resultSet == null)
            $this->resultSet = new ResultSetImpl($this, $this->stmt);
        return $this->resultSet;
    }

   

    protected function get($identifier){
        $stm =$this->con->prepareStatement('Select @'.$identifier);
        $rs = $stm->executeQuery();
        
        while ($rs->next()) {
            return ($rs->getString(0));
        }
    }

    public function getArray($identifier) {
        $this->checkedClosed();
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
//        $a = new ArrayObject();
//
//        return $a;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\math\BigDecimal
     */
    public function getDecimal($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        $pair = explode(',', $val);

        $d = new BigDecimal($val);

        return $d;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\Blob
     */
    public function getBlob($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return new BlobImpl(new \blaze\io\input\ByteArrayInputStream($val, $this->stmt));
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return boolean
     */
    public function getBoolean($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Integer::asNative($val) === 1;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getByte($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Byte::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\Clob
     */
    public function getClob($identifier) {
        throw new \blaze\lang\NotYetImplementedException();
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        var_dump($val);
        $c = new ClobImpl();

        return $c;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier) {
        //$this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return self::$dateFormatter->parseDate($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getDateTime($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;


        return self::$dateTimeFormatter->parseDate($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return double
     */
    public function getDouble($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Double::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return float
     */
    public function getFloat($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Float::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return int
     */
    public function getInt($identifier) {
        //$this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Integer::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return long
     */
    public function getLong($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Long::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\ds\type\NClob
     */
    public function getNClob($identifier) {
        throw new \blaze\lang\NotYetImplementedException();
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        var_dump($val);
        $n = new NClobImpl();

        return $n;
    }

    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getNString($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return String::asWrapper($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\lang\String
     */
    public function getString($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return String::asWrapper($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTime($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return self::$timeFormatter->parseDate($val);
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier) {
        return $this->getDateTime($identifier);
    }

    public function wasNull() {

    }




    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\collections\ArrayI $value
     * @return blaze\lang\PreparedStatement
     */
    public function setArray($identifier, \blaze\collections\ArrayI $value) {
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
        //return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\math\BigDecimal $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDecimal($identifier, \blaze\math\BigDecimal $value) {
        $this->set($identifier, $value->toString(), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\Blob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBlob($identifier, \blaze\ds\type\Blob $value) {
        $buffer = new \blaze\lang\StringBuffer();
        $value->getInputStream()->read($buffer);
        $this->set($identifier, $buffer->toString(), \PDO::PARAM_LOB);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param boolean $value
     * @return blaze\lang\PreparedStatement
     */
    public function setBoolean($identifier, $value) {
        $this->set($identifier, \blaze\lang\Boolean::asNative($value), \PDO::PARAM_BOOL);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\lang\PreparedStatement
     */
    public function setByte($identifier, $value) {
        $this->set($identifier, \blaze\lang\Byte::asNative($value), \PDO::PARAM_INT);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\Clob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setClob($identifier, \blaze\ds\type\Clob $value) {
        throw new \blaze\lang\NotYetImplementedException();
        //$this->set($identifier, $value->,\PDO::PARAM_LOB);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDate($identifier, \blaze\util\Date $value) {
        $str = self::$dateFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDateTime($identifier, \blaze\util\Date $value) {
        $str = self::$dateTimeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param double $value
     * @return blaze\lang\PreparedStatement
     */
    public function setDouble($identifier, $value) {
        $this->set($identifier, \blaze\lang\Double::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param float $value
     * @return blaze\lang\PreparedStatement
     */
    public function setFloat($identifier, $value) {
        $this->set($identifier, \blaze\lang\Float::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param int $value
     * @return blaze\lang\PreparedStatement
     */
    public function setInt($identifier, $value) {
        $this->set($identifier, \blaze\lang\Integer::asNative($value), \PDO::PARAM_INT);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param long $value
     * @return blaze\lang\PreparedStatement
     */
    public function setLong($identifier, $value) {
        $this->set($identifier, \blaze\lang\Long::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\ds\type\NClob $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNClob($identifier, \blaze\ds\type\NClob $value) {
        throw new \blaze\lang\NotYetImplementedException();
        $this->set($identifier, $value->toString(), \PDO::PARAM_STR);
        return $this;
    }

    /**
     * Varchar2
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNString($identifier, $value) {
        $this->set($identifier, \blaze\lang\String::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\lang\Object $value
     * @return blaze\lang\PreparedStatement
     */
    public function setNull($identifier) {
        $this->set($identifier, null, \PDO::PARAM_NULL);
        return $this;
    }

//, $value);

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param string|blaze\lang\String $value
     * @return blaze\lang\PreparedStatement
     */
    public function setString($identifier, $value) {
        $this->set($identifier, \blaze\lang\String::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTime($identifier, \blaze\util\Date $value) {
        $str = self::$timeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    /**
     *
     * @param blaze\lang\String|string|int $identifier
     * @param blaze\util\Date $value
     * @return blaze\lang\PreparedStatement
     */
    public function setTimestamp($identifier, \blaze\util\Date $value) {
        return $this->setDateTime($identifier, $value);
    }

}

?>
