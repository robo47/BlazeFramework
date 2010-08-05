<?php
namespace blaze\math;
use blaze\lang\Object;
use blaze\lang\Integer;
use blaze\lang\StaticInitialization;
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
class BigInteger extends Object implements StaticInitialization {
    private $value;
    private static $bcexists = false;

    public function __construct($value){
        $this->value = new String($value);
    }
     public static function staticInit(){
         if(function_exists('bcadd')&&function_exists('bcsub')&&function_exists('bcdiv')&&function_exists('bcmul')){
             BigInteger::$bcexists = true;
         }

     }
     public function add(BigInteger $summand){
         if(BigInteger::$bcexists){
            return new BigInteger(bcadd($this, $summand));
         }
         else{
            $ret = new \blaze\lang\StringBuffer('');
            $fragmentthis;
            $fragmentsummand;

         }

     }
     

     public function sub(BigInteger $subtrahend ){
         if(BigInteger::$bcexists){
            return new BigInteger(bcsub($this, $summand));
         }
     }

     public function div(BigInteger $divisor ){
         if(BigInteger::$bcexists){
            return new BigInteger(bcdiv($this, $divisor));
         }
     }

      public function mul(BigInteger $multiplicator ){
          if(BigInteger::$bcexists){
            return new BigInteger(bcmul($this, $multiplicator));
          }
     }
     

    public function __toString(){
        return String::asNative($this->value);
    }

}

?>
