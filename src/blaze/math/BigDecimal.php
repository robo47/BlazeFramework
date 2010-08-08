<?php
namespace blaze\math;
use blaze\lang\Object;
use blaze\lang\Integer;
use blaze\lang\Comparable;
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
class BigDecimal extends Object implements Comparable {
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

     /*
 * Computes the factoral (x!).
 * @author Thomas Oldbury.
 * @license Public domain.
 */
function bcfact($fact, $scale = 100)
{
    if($fact == 1) return 1;
    return bcmul($fact, bcfact(bcsub($fact, '1'), $scale), $scale);
}

/*
 * Computes e^x, where e is Euler's constant, or approximately 2.71828.
 * @author Thomas Oldbury.
 * @license Public domain.
 */
function bcexp($x, $iters = 7, $scale = 100)
{
    /* Compute e^x. */
    $res = bcadd('1.0', $x, $scale);
    for($i = 0; $i < $iters; $i++)
    {
        $res += bcdiv(bcpow($x, bcadd($i, '2'), $scale), bcfact(bcadd($i, '2'), $scale), $scale);
    }
    return $res;
}

/*
 * Computes ln(x).
 * @author Thomas Oldbury.
 * @license Public domain.
 */
function bcln($a, $iters = 10, $scale = 100)
{
    $result = "0.0";

    for($i = 0; $i < $iters; $i++)
    {
        $pow = bcadd("1.0", bcmul($i, "2.0", $scale), $scale);
        //$pow = 1 + ($i * 2);
        $mul = bcdiv("1.0", $pow, $scale);
        $fraction = bcmul($mul, bcpow(bcdiv(bcsub($a, "1.0", $scale), bcadd($a, "1.0", $scale), $scale), $pow, $scale), $scale);
        $result = bcadd($fraction, $result, $scale);
    }

    $res = bcmul("2.0", $result, $scale);
    return $res;
}

/*
 * Computes a^b, where a and b can have decimal digits, be negative and/or very large.
 * Also works for 0^0. Only able to calculate up to 10 digits. Quite slow.
 * @author Thomas Oldbury.
 * @license Public domain.
 */
function bcpowx($a, $b, $iters = 25, $scale = 100)
{
    $ln = bcln($a, $iters, $scale);
    return bcexp(bcmul($ln, $b, $scale), $iters, $scale);
}

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


