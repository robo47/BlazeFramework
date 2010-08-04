<?php
namespace blaze\math;
use blaze\lang\Object;
use blaze\lang\Integer;

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
class BigInteger extends Object {
    var $value;

    public function __construct($value){
        $this->value = $value;
     }

     public function add(BigInteger $summand){
         return new BigInteger(bcadd($this, $summand));
     }

     public function sub(BigInteger $subtrahend ){
         return new BigInteger(bcsub($this, $summand));
     }

     public function div(BigInteger $divisor ){
        return new BigInteger(bcdiv($this, $divisor));
     }

      public function mul(BigInteger $multiplicator ){
        return new BigInteger(bcmul($this, $multiplicator));
     }
     

    public function __toString(){
        return $this->value;
    }
}

?>
