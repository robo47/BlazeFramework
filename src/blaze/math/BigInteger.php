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
 * @author  Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class BigInteger extends Number implements StaticInitialization, Comparable {
    private $value;
    private static $bcExists = false;

    public function __construct($value){
        $this->value = new String($value);
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

    public static function staticInit(){
         if(function_exists('bcadd')){
             self::$bcExists = true;
         }

     }
     public function add(BigInteger $summand){
         if(BigInteger::$bcExists){
            return new BigInteger(bcadd($this, $summand));
         }
         else{
            $ret = new \blaze\lang\StringBuffer('');
            $fragmentthis;
            $fragmentsummand;

         }

     }
     

     public function sub(BigInteger $subtrahend ){
         if(BigInteger::$bcExists){
            return new BigInteger(bcsub($this, $summand));
         }
     }

     public function div(BigInteger $divisor ){
         if(BigInteger::$bcExists){
            return new BigInteger(bcdiv($this, $divisor));
         }
     }

      public function mul(BigInteger $multiplicator ){
          if(BigInteger::$bcExists){
            return new BigInteger(bcmul($this, $multiplicator));
          }
     }
     

    public function __toString(){
        return String::asNative($this->value);
    }
    public function compareTo(Object $obj) {

    }


}

?>
