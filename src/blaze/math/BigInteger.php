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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class BigInteger extends Object {
    //Java Implementation
     /**
     * The signum of this BigInteger: -1 for negative, 0 for zero, or
     * 1 for positive.  Note that the BigInteger zero <i>must</i> have
     * a signum of 0.  This is necessary to ensures that there is exactly one
     * representation for each BigInteger value.
     *
     * @serial
     */
    var $signum;

    /**
     * The magnitude of this BigInteger, in <i>big-endian</i> order: the
     * zeroth element of this array is the most-significant int of the
     * magnitude.  The magnitude must be "minimal" in that the most-significant
     * int ({@code mag[0]}) must be non-zero.  This is necessary to
     * ensure that there is exactly one representation for each BigInteger
     * value.  Note that this implies that the BigInteger zero has a
     * zero-length mag array.
     */
    var $mag;

    // These "redundant fields" are initialized with recognizable nonsense
    // values, and cached the first time they are needed (or never, if they
    // aren't needed).




    //Constructors
     public function __construct($value, $signum = 1, $random = null){
        $nullflag = true;
        $this->mag = array();
        $this->signum = $signum;
         if(is_string($value)){
            $intervall = 9;

            $len = strlen($value);
            $cur = 0;
            for($cur = 0; $cur<$len;$cur=$cur+9){

               $curstring = substr($value, $cur,$intervall);
               $intval = intval($curstring);
               if($intval==0&&$nullflag){
                   $this->mag[$cur/9] = 0;
               }
               else{
                   $nullflag = false;
                   $this->mag[$cur/9] = $intval;
               }

            }
             if($nullflag){
                 $this->signum = 0;
             }

        }
     }

     public function add(BigInteger $val){
        if($this->signum == 0){
            return $val;
        }
        if($val->signum == 0){
            return $this;
        }
        if($this->signum == $val->signum){


        }

     }

     private function addMagnitude($mag){

     }

    public function compareTo(Object $obj) {

    }
     public function __toString(){
          if($this->signum == 0){
              return '0';
          }
         if($this->signum == -1){
             $ret = '-';
         }
         else{
             $ret = '';
         }
         foreach($this->mag AS $element){
            $ret = $ret.$element;
         }
         return  $ret;
     }

}

?>
