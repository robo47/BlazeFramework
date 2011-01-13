<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\Boolean,
 blaze\lang\Long,
 blaze\lang\Float,
 blaze\lang\Byte,
 blaze\lang\Short,
 blaze\lang\Integer,
 blaze\lang\Double,
 blaze\math\BigDecimal,
 blaze\ds\Statement,
 blaze\ds\DataSourceException,
 blaze\ds\driver\pdobase\AbstractResultSet,
 blaze\ds\driver\pdomysql\type\BlobImpl,
 blaze\ds\driver\pdomysql\type\ClobImpl,
 blaze\ds\driver\pdomysql\type\NClobImpl;

/**
 * Description of ResultSetImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class ResultSetImpl extends AbstractResultSet implements \blaze\lang\StaticInitialization {

    private static $dateFormatter;
    private static $dateTimeFormatter;
    private static $timeFormatter;

    public static function staticInit() {
        self::$dateFormatter = new \blaze\text\DateFormat('Y-m-d');
        self::$dateTimeFormatter = new \blaze\text\DateFormat('Y-m-d H:i:s');
        self::$timeFormatter = new \blaze\text\DateFormat('H:i:s');
    }

    public function __construct(Statement $stmt, \PDOStatement $pdoStmt, $type) {
        parent::__construct($stmt, $pdoStmt, $type);
    }

    public function getMetaData() {
        $this->checkClosed();
        if ($this->rsmd == null)
            $this->rsmd = new \blaze\ds\driver\pdomysql\meta\ResultSetMetaDataImpl($this, $this->pdoStmt);
        return $this->rsmd;
    }

    public function getArray($identifier) {
        $this->checkClosed();
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
//        $a = new ArrayObject();
//
//        return $a;
    }

    public function getDecimal($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        $pair = explode(',', $val);
        $d = new BigDecimal($val);

        return $d;
    }

    public function getBlob($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val === null)
            return null;

        if(!is_resource($val))
            return new BlobImpl(new \blaze\io\input\ByteArrayInputStream($val));
        else
            return new BlobImpl(new \blaze\io\input\FilterNativeInputStream($val));
    }

    public function getBoolean($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Integer::asNative($val) === 1;
    }

    public function getByte($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Byte::asNative($val);
    }

    public function getShort($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Short::asNative($val);
    }

    public function getClob($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val === null)
            return null;

        if(!is_resource($val))
            return new ClobImpl(new \blaze\io\input\ByteArrayInputStream($val));
        else
            return new ClobImpl(new \blaze\io\input\FilterNativeInputStream($val));
    }

    public function getDate($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;


        return self::$dateFormatter->parseDate($val);
    }

    public function getDateTime($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;


        return self::$dateTimeFormatter->parseDate($val);
    }

    public function getDouble($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Double::asNative($val);
    }

    public function getFloat($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Float::asNative($val);
    }

    public function getInt($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Integer::asNative($val);
    }

    public function getLong($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Long::asNative($val);
    }

    public function getNClob($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val === null)
            return null;

        if(!is_resource($val))
            return new NClobImpl(new \blaze\io\input\ByteArrayInputStream($val));
        else
            return new NClobImpl(new \blaze\io\input\FilterNativeInputStream($val));
    }

    public function getString($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return String::asWrapper($val);
    }

    public function getTime($identifier) {
        $this->checkClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return self::$timeFormatter->parseDate($val);
    }

    public function getTimestamp($identifier) {
        return $this->getDateTime($identifier);
    }

}

?>
