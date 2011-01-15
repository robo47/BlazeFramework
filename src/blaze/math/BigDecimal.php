<?php

namespace blaze\math;

use blaze\lang\Object;
use blaze\lang\Integer;
use blaze\lang\StaticInitialization;
use blaze\lang\Comparable;
use blaze\lang\Number;
use blaze\lang\String;

/**
 * Description of BigDecimal
 *
 * @author  Christian Beikov, Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Scale not properly set if the value in the constructor has the format 10.0e-20
 */
class BigDecimal extends \blaze\lang\Number implements StaticInitialization, Comparable {

    private static $bcExists;
    private $value;
    private $scale;


    public static function staticInit() {
        if (function_exists('bcadd')) {
            self::$bcExists = true;
        }
    }
    
    /**
     * Generate a new BigDecimal Object.
     * @param <int|string|float|blaze\lang\Number> $value Is a native String, with scale and algebric sign
     * @param <type> $scale If value has no scale you can define the scale
     */
    public function __construct($value, $scale = null) {
        if(($class = Number::getNumberClass($value)) !== null){
            $className = $class->getName()->toNative();
            $value = $className::asNative($value);
        }else if(!self::isNativeType($value))
            throw new \blaze\lang\NumberFormatException('Not a valid representation of BigDecimal!');

        $this->value = String::asNative($value);
        
        if ($scale != null) {
            $this->scale = $scale;
        } else {
            $ar = explode('.', $this->value);
            $count = count($ar);

            if($count > 2)
                throw new \blaze\lang\NumberFormatException('Not a valid representation of BigDecimal!');
            
            if($count == 2)
                $this->scale = strlen($ar[1]);
            else
                $this->scale = 0;
        }
    }

    private function getIntVal() {
        $ar = explode('.', $this->value);
        return $ar[0];
    }

    public static function isNativeType($value) {
        if(is_numeric($value))
            return true;
        return preg_match('/^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$/', $value) === 1;
    }

    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    public static function isWrapperType($value) {
        return $value instanceof BigDecimal;
    }

    public function toNative() {
        return $this->value;
    }

    public function byteValue() {
        \blaze\lang\Byte::asNative($this->getIntVal());
    }

    public function doubleValue() {
        \blaze\lang\Double::asNative($this->value);
    }

    public function floatValue() {
        \blaze\lang\Float::asNative($this->value);
    }

    public function intValue() {
        \blaze\lang\Integer::asNative($this->getIntVal());
    }

    public function longValue() {
        \blaze\lang\Long::asNative($this->getIntVal());
    }

    public function shortValue() {
        \blaze\lang\Short::asNative($this->getIntVal());
    }

    public function getScale() {
        return $this->scale;
    }

    public function setScale($scale) {
        $this->scale = $scale;
    }

    public function negate() {

        return $this->multiply(new BigDecimal(-1));
    }

    /**
     * Add to BigDecimal.
     * @param blaze\math\BigDecimal $summand The Object wich should be add to the this
     * Object.
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return blaze\math\BigDecimal The Output of the Operation
     */
    public function add(BigDecimal $summand, Integer $scale = null) {
        if ($scale == null) {
            return new BigDecimal(bcadd($this, $summand, $this->scale));
        } else {
            return new BigDecimal(bcadd($this, $summand, $scale));
        }
    }

    /**
     *
     * @param blaze\math\BigDecimal $subtrahend
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return blaze\math\BigDecimal The Output of the Operation
     */
    public function subtract(BigDecimal $subtrahend, Integer $scale = null) {
        if ($scale == null) {
            return new BigDecimal(bcsub($this, $summand, $this->scale));
        } else {
            return new BigDecimal(bcsub($this, $summand, $scale));
        }
    }

    /**
     *
     * @param blaze\math\BigDecimal $divisor
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return blaze\math\BigDecimal The Output of the Operation
     */
    public function divide(BigDecimal $divisor, Integer $scale = null) {

        if ($scale == null) {
            return new BigDecimal(bcdiv($this, $divisor, $this->scale));
        } else {
            return new BigDecimal(bcdiv($this, $divisor, $scale));
        }
    }

    /**
     *
     * @param blaze\math\BigDecimal $multiplicator
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return blaze\math\BigDecimal The Output of the Operation
     */
    public function multiply(BigDecimal $multiplicator, Integer $scale = null) {

        if ($scale == null) {
            return new BigDecimal(bcmul($this, $multiplicator, $this->scale + $multiplicator->scale));
        } else {
            return new BigDecimal(bcmul($this, $multiplicator, $scale));
        }
    }

    /**
     * Factoral the this Object.
     * @param <int> $scale
     * @return blaze\math\BigDecimal
     */
    public function factoral($scale = 100) {
        if ($this->value == 1)
            return 1;
        return new BigDecimal(bcmul($this->value, bcfact(bcsub($this->value, '1'), $scale), $scale));
    }

    /**
     * Computes e^this, where e is Euler's constant.
     * @param <int> $iters
     * @param <int> $scale
     * @return blaze\math\BigDecimal
     */
    public function exponentialteWithE($iters = 7, $scale = 100) {
        /* Compute e^x. */
        $res = bcadd('1.0', $this->value, $scale);
        for ($i = 0; $i < $iters; $i++) {
            $res += bcdiv(bcpow($this->value, bcadd($i, '2'), $scale), bcfact(bcadd($i, '2'), $scale), $scale);
        }
        return new BigDecimal($res);
    }

    /**
     * ln(this).
     * @param <int> $iters
     * @param <int> $scale
     * @return blaze\math\BigDecimal
     */
    public function logarithmize($iters = 10, $scale = 100) {
        $result = "0.0";

        for ($i = 0; $i < $iters; $i++) {
            $pow = bcadd("1.0", bcmul($i, "2.0", $scale), $scale);
            //$pow = 1 + ($i * 2);
            $mul = bcdiv("1.0", $pow, $scale);
            $fraction = bcmul($mul, bcpow(bcdiv(bcsub($this->value, "1.0", $scale), bcadd($this->value, "1.0", $scale), $scale), $pow, $scale), $scale);
            $result = bcadd($fraction, $result, $scale);
        }

        $res = bcmul("2.0", $result, $scale);
        return new BigDecimal($res);
    }

    /**
     * Computes this^b
     *
     * @param <blaze\math\BigDecimal> $b
     * @param <int> $iters
     * @param <int> $scale
     * @return blaze\math\BigDecimal
     */
    public function exponentialte($b, $iters = 25, $scale = 100) {
        $ln = bcln($this->value, $iters, $scale);
        return new BigDecimal(bcexp(bcmul($ln, $b . asNative(), $scale), $iters, $scale));
    }

    /**
     * Gives you a random BigDecimal Object
     * @param int $min
     * @param <blaze\math\BigDecimal> $max
     * @return blaze\math\BigDecimal
     */
    public static function getrandom($min, $max=false) {
        $min = $min . asNative();
        $max = $max . asNative();
        if (!$max) {
            $max = $min;
            $min = 0;
        }


        return new BigDecimal(bcadd(
                        bcmul(
                                bcdiv(
                                        mt_rand(0, mt_getrandmax()),
                                        mt_getrandmax(),
                                        strlen($max)
                                ),
                                bcsub(
                                        bcadd($max, 1),
                                        $min
                                )
                        ),
                        $min
        ));
    }

    public function toString() {
        return $this->value;
    }

    public function compareTo(Object $obj) {
        if ($obj === null)
            throw new NullPointerException();
        if ($obj instanceof BigDecimal)
            return bccomp($this->value, $obj->value);
        throw new ClassCastException('Could not cast ' . $obj->getClass()->getName() . ' to BigDecimal.');
    }

}
?>


