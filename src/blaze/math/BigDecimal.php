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
     * @param <type> $value Is a native String, with scale and algebric sign
     * @param <type> $scale If value has no scale you can define the scale
     */
    public function __construct($value, $scale = null){
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

    public static function asNative($value) {

    }

    public static function asWrapper($value) {

    }

    public static function isNativeType($value) {

    }

    public static function isType($value) {

    }

    public static function isWrapperType($value) {

    }

    public function toNative() {

    }

    public function byteValue() {

    }

    public function doubleValue() {

    }

    public function floatValue() {

    }

    public function intValue() {

    }

    public function longValue() {

    }

    public static function parse($value) {

    }

    public function shortValue() {

    }


    /**
     *Add to BigDecimal.
     * @param BigDecimal $summand The Object wich should be add to the this
     * Object.
     * @param Integer $scale You can define the scale of the new BigDecimal.
     * @return BigDecimal The Output of the Operation
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
 * @param BigDecimal $subtrahend
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return BigDecimal The Output of the Operation
 */
     public function sub(BigDecimal $subtrahend , Integer $scale = null){
        if($scale == null){
            return new BigDecimal(bcsub($this, $summand,$this->scale));
         }
         else{
             return new BigDecimal(bcsub($this, $summand,$scale));
         }
         }
     
/**
 *
 * @param BigDecimal $divisor
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return BigDecimal The Output of the Operation
 */
     public function div(BigDecimal $divisor , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcdiv($this, $divisor,$this->scale));
         }
         else{
             return new BigDecimal(bcdiv($this, $divisor,$scale));
         }
     }
/**
 *
 * @param BigDecimal $multiplicator
 * @param Integer $scale You can define the scale of the new BigDecimal.
 * @return BigDecimal The Output of the Operation
 */
      public function mul(BigDecimal $multiplicator , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcmul($this, $multiplicator,$this->scale+$multiplicator->scale));
         }
         else{
             return new BigDecimal(bcmul($this, $multiplicator,$scale));
         }
     }

     /**
      *
      *  * Computes the factoral (this!).
 * @author Thomas Oldbury.
 * @license Public domain.
      * @param <type> $scale
      * @return BigDecimal
      */
function fact($scale = 100)
{
    if($this->value == 1) return 1;
    return new BigDecimal(bcmul($this->value, bcfact(bcsub($this->value, '1'), $scale), $scale));
}


/**
 * Computes e^this, where e is Euler's constant, or approximately 2.71828.
 * @author Thomas Oldbury.
 * @license Public domain.
 * @param <type> $iters
 * @param <type> $scale
 * @return BigDecimal
 */
function bcexp ($iters = 7, $scale = 100)
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
 *Computes ln(this).
 * @author Thomas Oldbury.
 * @license Public domain.
 * @param <type> $iters
 * @param <type> $scale
 * @return BigDecimal
 */
function bcln( $iters = 10, $scale = 100)
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
 *Computes this^b, where a and b can have decimal digits, be negative and/or very large.
 * Also works for 0^0. Only able to calculate up to 10 digits. Quite slow.
 * @author Thomas Oldbury.
 * @license Public domain.
 *
 * @param <type> $b
 * @param <type> $iters
 * @param <type> $scale
 * @return BigDecimal
 */
function bcpowx($b, $iters = 25, $scale = 100)
{
    $ln = bcln($this->value, $iters, $scale);
    return new BigDecimal(bcexp(bcmul($ln, $b, $scale), $iters, $scale));
}
/**
 * Gives you a random BigDecimal Object
 * @param int $min
 * @param <type> $max
 * @return BigDecimal
 */
public static function bcrand($min, $max=false)
{
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

    public function __toString(){
        return $this->value;
    }

    public function compareTo(Object $obj){
        $hthis = new String($this->value);
        $hobj = new String($obj->value);

        return $hthis->compareTo($hobj);

    }


}

?>


