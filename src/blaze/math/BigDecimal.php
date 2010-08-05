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

     public function add(BigDecimal $summand, Integer $scale = null){
         if($scale == null){
            return new BigDecimal(bcadd($this, $summand,$this->scale));
         }
         else{
             return new BigDecimal(bcadd($this, $summand,$scale));
         }
     }

     public function sub(BigDecimal $subtrahend , Integer $scale = null){
        if($scale == null){
            return new BigDecimal(bcsub($this, $summand,$this->scale));
         }
         else{
             return new BigDecimal(bcsub($this, $summand,$scale));
         }
         }
     

     public function div(BigDecimal $divisor , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcdiv($this, $divisor,$this->scale));
         }
         else{
             return new BigDecimal(bcdiv($this, $divisor,$scale));
         }
     }

      public function mul(BigDecimal $multiplicator , Integer $scale = null){

        if($scale == null){
         return new BigDecimal(bcmul($this, $multiplicator,$this->scale+$multiplicator->scale));
         }
         else{
             return new BigDecimal(bcmul($this, $multiplicator,$scale));
         }
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


