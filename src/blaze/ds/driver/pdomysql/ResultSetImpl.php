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
 blaze\util\ArrayObject,
 blaze\math\BigDecimal,
 blaze\ds\Statement1,
 blaze\ds\SQLException,
 blaze\ds\driver\pdobase\AbstractResultSet,
 blaze\ds\driver\pdomysql\type\BlobImpl,
 blaze\ds\driver\pdomysql\type\ClobImpl,
 blaze\ds\driver\pdomysql\type\NClobImpl;

/**
 * Description of ResultSetImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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

    public function __construct(Statement1 $stmt, \PDOStatement $pdoStmt) {
        parent::__construct($stmt, $pdoStmt);
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\ArrayObject
     */
    public function getArray($identifier) {
        $this->checkedClosed();
        throw new \blaze\lang\UnsupportedOperationException('There is no array datatype in mysql.');
//        $a = new ArrayObject();
//
//        return $a;
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\ds\type\Blob
     */
    public function getBlob($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return new BlobImpl(new \blaze\io\ByteArrayInputStream($val, $this->stmt));
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getDate($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;


        return self::$dateFormatter->parseDate($val);
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
     * @return integer
     */
    public function getInt($identifier) {
        $this->checkedClosed();
        $val = $this->get($identifier);

        if ($val == null)
            return null;

        return Integer::asNative($val);
    }

    /**
     *
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
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
     * @param blaze\lang\String|string|integer $identifier
     * @return blaze\util\Date
     */
    public function getTimestamp($identifier) {
        return $this->getDateTime($identifier);
    }

}
?>
