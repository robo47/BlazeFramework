<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 \blaze\ds\driver\pdobase\AbstractPreparedStatement,
 \blaze\ds\Connection,
 \blaze\ds\DataSourceException;

/**
 * Description of PreparedStatementImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class PreparedStatementImpl extends AbstractPreparedStatement implements \blaze\lang\StaticInitialization {

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
    
    /**
     *
     * @return blaze\ds\ResultSet
     */
    public function executeQuery($query = null) {
        $this->checkClosed();

        try {
            if ($this->stmt->execute() === false) {
                throw new DataSourceException('Could not execute query. ' . $this->stmt->errorInfo());
            }

            if ($this->stmt->columnCount() === 0)
                throw new DataSourceException('Statement has no resultset.');

            $this->resultSet = new \blaze\ds\driver\pdomysql\ResultSetImpl($this, $this->stmt, $this->resultSetType);
            return $this->resultSet;
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }
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

}

?>
