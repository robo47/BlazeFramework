<?php

namespace blaze\math;

use blaze\lang\Object;
use blaze\lang\Integer;
use blaze\lang\StaticInitialization;
use blaze\lang\Comparable;
use blaze\lang\Number;
use blaze\lang\String;

/**
 * Description of BigInteger
 *
 * @author  Christian Beikov, Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class BigInteger extends Number implements StaticInitialization {

    private $value;
    private static $bcExists = false;


    public static function staticInit() {
        if (function_exists('bcadd')) 
            self::$bcExists = true;
    }
    
    public function __construct($value) {
        if(($class = Number::getNumberClass($value)) !== null)
            $value = $class->getMethod('asNative')->invoke(null, $value);
        else if(!self::isNativeType($value))
            throw new \blaze\lang\NumberFormatException('Not a valid representation of BigInteger!');
        $this->value = String::asNative($value);
    }

    public static function isNativeType($value) {
        if(is_numeric($value) && round($value) != $value)
            return false;
        return preg_match('/^[-+]?[0-9]+$/', $value) === 1;
    }

    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    public static function isWrapperType($value) {
        return $value instanceof BigInteger;
    }

    public function toNative() {
        return $this->value;
    }

    public function byteValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function doubleValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function floatValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function intValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function longValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function shortValue() {
        return \blaze\lang\Byte::asNative($this->value);
    }

    public function add(BigInteger $summand) {
        if (BigInteger::$bcExists) {
            return new BigInteger(bcadd($this, $summand));
        } else {
            $ret = new \blaze\lang\StringBuffer('');
            $fragmentthis;
            $fragmentsummand;
        }
    }

    public function sub(BigInteger $subtrahend) {
        if (BigInteger::$bcExists) {
            return new BigInteger(bcsub($this, $summand));
        }
    }

    public function div(BigInteger $divisor) {
        if (BigInteger::$bcExists) {
            return new BigInteger(bcdiv($this, $divisor));
        }
    }

    public function mul(BigInteger $multiplicator) {
        if (BigInteger::$bcExists) {
            return new BigInteger(bcmul($this, $multiplicator));
        }
    }

    public function toString() {
        return String::asWrapper($this->value);
    }

    public static function compare($obj1, $obj2) {
        if ($obj1 === null || $obj2 === null)
            return new NullPointerException();
        return bccomp(static::asNative($obj1), static::asNative($obj2));
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof BigInteger)
            return bccomp($this->value, $obj->value);
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to BigInteger.');
    }


}
?>
