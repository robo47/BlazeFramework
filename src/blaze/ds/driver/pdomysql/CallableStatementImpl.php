<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\Boolean,
 blaze\lang\Long,
 blaze\lang\Float,
 blaze\lang\Byte,
 blaze\lang\Integer,
 blaze\lang\Double,
 blaze\math\BigDecimal,
 blaze\ds\Statement,
 blaze\ds\DataSourceException,
 blaze\ds\driver\pdobase\AbstractResultSet,
 blaze\ds\driver\pdomysql\type\BlobImpl,
 blaze\ds\driver\pdomysql\type\ClobImpl,
 blaze\ds\driver\pdomysql\type\NClobImpl,
 \blaze\ds\driver\pdobase\AbstractCallableStatement,
 \blaze\ds\Connection,
 \blaze\ds\CallableStatement,
 \blaze\ds\driver\pdobase\AbstractStatement;

/**
 * Description of CallableStatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
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

    public function __construct(Connection $con, \PDO $pdo, $query, $type) {
        parent::__construct($con, $pdo, $query, $type);
    }

    public function getMetaData() {
        $this->checkClosed();
        if ($this->rsmd == null)
            $this->rsmd = new \blaze\ds\driver\pdomysql\meta\ResultSetMetaDataImpl($this, $this->stmt);
        return $this->rsmd;
    }

    public function getResultSet() {
        $this->checkClosed();
        if ($this->stmt == null)
            return null;
        if ($this->resultSet == null)
            $this->resultSet = new ResultSetImpl($this, $this->stmt, $this->resultSetType);
        return $this->resultSet;
    }

    protected function get($identifier) {
        $this->checkClosed();
        $stm = $this->con->prepareStatement('Select @' . $identifier);
        $rs = $stm->executeQuery();

        return $rs;
    }

    public function getArray($identifier) {
        return $this->get($identifier)->getArray(0);
    }

    public function getDecimal($identifier) {
        return $this->get($identifier)->getDecimal(0);
    }

    public function getBlob($identifier) {
        return $this->get($identifier)->getBlob(0);
    }

    public function getBoolean($identifier) {
        return $this->get($identifier)->getBoolean(0);
    }

    public function getByte($identifier) {
        return $this->get($identifier)->getByte(0);
    }

    public function getShort($identifier) {
        return $this->get($identifier)->getShort(0);
    }

    public function getClob($identifier) {
        return $this->get($identifier)->getClob(0);
    }

    public function getDate($identifier) {
        return $this->get($identifier)->getDate(0);
    }

    public function getDateTime($identifier) {
        return $this->get($identifier)->getDateTime(0);
    }

    public function getDouble($identifier) {
        return $this->get($identifier)->getDouble(0);
    }

    public function getFloat($identifier) {
        return $this->get($identifier)->getFloat(0);
    }

    public function getInt($identifier) {
        return $this->get($identifier)->getInt(0);
    }

    public function getLong($identifier) {
        return $this->get($identifier)->getLong(0);
    }

    public function getNClob($identifier) {
        return $this->get($identifier)->getNClob(0);
    }

    public function getString($identifier) {
        return $this->get($identifier)->getString(0);
    }

    public function getTime($identifier) {
        return $this->get($identifier)->getTime(0);
    }

    public function getTimestamp($identifier) {
        return $this->get($identifier)->getTimestamp(0);
    }


    public function setArray($identifier, \blaze\collections\ArrayI $value) {
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
        //return $this;
    }

    public function setDecimal($identifier, \blaze\math\BigDecimal $value) {
        $this->set($identifier, $value->toString(), \PDO::PARAM_STR);
        return $this;
    }

    public function setBlob($identifier, \blaze\ds\type\Blob $value) {
        $stream = $value->getInputStream();

        if($stream instanceof type\NativePipedInputStream){
            $native = $stream->getNativeStream();
            fseek($native, 0, SEEK_SET);
            $this->set($identifier, $native, \PDO::PARAM_LOB);
        }else{
            $buffer = new \blaze\lang\StringBuffer();
            $content = $stream->read($buffer);
            $this->set($identifier, $buffer->toString());
        }
        return $this;
    }

    public function setBoolean($identifier, $value) {
        $this->set($identifier, \blaze\lang\Boolean::asNative($value), \PDO::PARAM_BOOL);
        return $this;
    }

    public function setByte($identifier, $value) {
        $this->set($identifier, \blaze\lang\Byte::asNative($value), \PDO::PARAM_INT);
        return $this;
    }

    public function setShort($identifier, $value) {
        $this->set($identifier, \blaze\lang\Short::asNative($value), \PDO::PARAM_INT);
        return $this;
    }

    public function setClob($identifier, \blaze\ds\type\Clob $value) {
        $stream = $value->getInputStream();

        if($stream instanceof type\NativePipedInputStream){
            $native = $stream->getNativeStream();
            fseek($native, 0, SEEK_SET);
            $this->set($identifier, $native, \PDO::PARAM_LOB);
        }else{
            $buffer = new \blaze\lang\StringBuffer();
            $content = $stream->read($buffer);
            $this->set($identifier, $buffer->toString());
        }
        return $this;
    }

    public function setDate($identifier, \blaze\util\Date $value) {
        $str = self::$dateFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    public function setDateTime($identifier, \blaze\util\Date $value) {
        $str = self::$dateTimeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    public function setDouble($identifier, $value) {
        $this->set($identifier, \blaze\lang\Double::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    public function setFloat($identifier, $value) {
        $this->set($identifier, \blaze\lang\Float::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    public function setInt($identifier, $value) {
        $this->set($identifier, \blaze\lang\Integer::asNative($value), \PDO::PARAM_INT);
        return $this;
    }

    public function setLong($identifier, $value) {
        $this->set($identifier, \blaze\lang\Long::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    public function setNClob($identifier, \blaze\ds\type\NClob $value) {
        $stream = $value->getInputStream();

        if($stream instanceof type\NativePipedInputStream){
            $native = $stream->getNativeStream();
            fseek($native, 0, SEEK_SET);
            $this->set($identifier, $native, \PDO::PARAM_LOB);
        }else{
            $buffer = new \blaze\lang\StringBuffer();
            $content = $stream->read($buffer);
            $this->set($identifier, $buffer->toString());
        }
        return $this;
    }

    public function setNull($identifier) {
        $this->set($identifier, null, \PDO::PARAM_NULL);
        return $this;
    }

    public function setString($identifier, $value) {
        $this->set($identifier, \blaze\lang\String::asNative($value), \PDO::PARAM_STR);
        return $this;
    }

    public function setTime($identifier, \blaze\util\Date $value) {
        $str = self::$timeFormatter->format($value);
        $this->set($identifier, $str);
        return $this;
    }

    public function setTimestamp($identifier, \blaze\util\Date $value) {
        return $this->set($identifier, $value->getUnixTime());
    }

    public function executeQuery($query = null) {
        
    }

}

?>
