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
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class BigDecimal extends \blaze\lang\Number implements StaticInitialization, Comparable {
    private static $bcExists;
    private $value;
    private $scale;

    /**
     * Generate a new BigDecimal Object.
     * @param <int|string|float|blaze\lang\Number> $value Is a native String, with scale and algebric sign
     * @param <type> $scale If value has no scale you can define the scale
     */
    public function __construct($value, $scale = null){
        if($value instanceof  Number){
            $value = $value.doubleValue;
        }

        $this->value = trim($value,'0');
        if($scale!=null){
            $this->scale = $scale;
        }
        else{
            $ar = split('[\.]', $this->value);
            if($ar[1]!=null){
                $this->scale = strlen($ar[1]);
            }
            else
                $this->scale = 0;
            }
    }
    public static function staticInit(){
         if(function_exists('bcadd')){
             self::$bcExists = true;
         }

     }

     private function getIntVal(){
         $ar = split('[\.]', $this->value);
         return $ar[0];
     }

    public static function asNative($value) {
        return $this->value;
    }

    public static function asWrapper($value) {
        return new BigDecimal($value);
    }

    public static function isNativeType($value) {
        return is_string($var);
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
        \blaze\lang\Byte::asWrapper($this->getIntVal());
    }

    public function doubleValue() {
        \blaze\lang\Double::asNative($this->value);
    }

    public function floatValue() {
        \blaze\lang\Float::asWrapper($this->value);
    }

    public function intValue() {
        Integer::asWrapper($this->getIntVal());
    }

    public function longValue() {
        \blaze\lang\Long::asWrapper($this->getIntVal());
    }

    public static function parse($value) {

    }

    public function shortValue() {
        \blaze\lang\Short::asWrapper($this->getIntVal());
    }

    public function getScale(){
        return $this->scale;
    }

    public function setScale($scale){
        $this->scale = $scale;
    }

    public function negate(){

        return $this->multiply(new BigDecimal(-1));
    }


    /**
     *Add to BigDecimal.
     * @param blaze\math\BigDecimal $summand The Object wich should be add to the this
     * Object.
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return blaze\math\BigDecimal The Output of the Operation
     */
     public function add(BigDecimal $summand, Integer $scale = null){
         if($scale == null){
            return new BigDecimal(bcadd($this, $summand,$this->scale));
         }
         else{
             return new BigDecimal(bcadd($this, $summand,$scale));
         }
     }
/**
 *
 * @param blaze\math\BigDecimal $subtrahend
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return blaze\math\BigDecimal The Output of the Operation
 */
     public function subtract(BigDecimal $subtrahend , Integer $scale = null){
        if($scale == null){
            return new BigDecimal(bcsub($this, $summand,$this->scale));
         }
         else{
             return new BigDecimal(bcsub($this, $summand,$scale));
         }
         }
     
/**
 *
 * @param blaze\math\BigDecimal $divisor
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return blaze\math\BigDecimal The Output of the Operation
 */
     public function divide(BigDecimal $divisor , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcdiv($this, $divisor,$this->scale));
         }
         else{
             return new BigDecimal(bcdiv($this, $divisor,$scale));
         }
     }
/**
 *
 * @param blaze\math\BigDecimal $multiplicator
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return blaze\math\BigDecimal The Output of the Operation
 */
      public function multiply(BigDecimal $multiplicator , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcmul($this, $multiplicator,$this->scale+$multiplicator->scale));
         }
         else{
             return new BigDecimal(bcmul($this, $multiplicator,$scale));
         }
     }

     /**
      * Factoral the this Object.
      * @param <int> $scale
      * @return blaze\math\BigDecimal
      */
public function factoral($scale = 100)
{
    if($this->value == 1) return 1;
    return new BigDecimal(bcmul($this->value, bcfact(bcsub($this->value, '1'), $scale), $scale));
}


/**
 * Computes e^this, where e is Euler's constant.
 * @param <int> $iters
 * @param <int> $scale
 * @return blaze\math\BigDecimal
 */
public function exponentialteWithE ($iters = 7, $scale = 100)
{
    /* Compute e^x. */
    $res = bcadd('1.0', $this->value, $scale);
    for($i = 0; $i < $iters; $i++)
    {
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
public function logarithmize( $iters = 10, $scale = 100)
{
    $result = "0.0";

    for($i = 0; $i < $iters; $i++)
    {
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
public function exponentialte($b, $iters = 25, $scale = 100)
{
    $ln = bcln($this->value, $iters, $scale);
    return new BigDecimal(bcexp(bcmul($ln,$b.asNative(), $scale), $iters, $scale));
}
/**
 * Gives you a random BigDecimal Object
 * @param int $min
 * @param <blaze\math\BigDecimal> $max
 * @return blaze\math\BigDecimal
 */
public static function getrandom($min, $max=false)
{
    $min = $min.asNative();
    $max = $max.asNative();
    if(!$max)
    {
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
                        bcadd($max,1),
                        $min
                    )

                ),
                $min
            ));
}

    public function toString(){
        return $this->value;
    }

    public function compareTo(Object $obj){
        $hthis = new String($this->value);
        $hobj = new String($obj->value);

        return $hthis->compareTo($hobj);

    }


}

?>


