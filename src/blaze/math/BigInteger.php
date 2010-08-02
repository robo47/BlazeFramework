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
           return new BigInteger($this->addMagnitude($val->mag, $this->$signum, null));

        }

     }

     private function addMagnitude($mag){
        $countthis = count($this->mag);
        $countpara = count($mag);
        $newmag = array();

        if($countthis == $countpara){
            $overlay =0;
            while($countthis>=0){
                $addfield = $this->mag[$countpara]+$mag[$countpara];
                $addfield = $addfield+$overlay;
                if($addfield>999999999){
                    $overlay = $addfield -999999999;
                    $newmag[$countpara]= 999999999;
                }
                else{
                    $overlay = 0;
                    $newmag[$countpara] = $addfield;
                }
                $countpara--;
            }
            return $newmag;
        }
        if($countpara>$countthis){
            $overlay =0;
            while($countthis>=0){
                $addfield = $this->mag[$countthis]+$mag[$countpara];
                $addfield = $addfield+$overlay;
                if($addfield>999999999){
                    $overlay = $addfield -999999999;
                    $newmag[$countpara]= 999999999;
                }
                else{
                    $overlay = 0;
                    $newmag[$countpara] = $addfield;
                }
                $countpara--;
                $countthis--;
            }
            while($countpara>=0){
                $newmag[$countpara] = $mag[$countpara];
            }
            return $newmag;
        }
        if($countpara<$countthis){

            $overlay =0;
            while($countpara>=0){
                $addfield = $this->mag[$countthis]+$mag[$countpara];
                $addfield = $addfield+$overlay;
                if($addfield>999999999){
                    $overlay = $addfield -999999999;
                    $newmag[$countthis]= 999999999;
                }
                else{
                    $overlay = 0;
                    $newmag[$countthis] = $addfield;
                }
                $countpara--;
                $countthis--;
            }
            while($countthis>=0){
                $newmag[$countthis] = $mag[$countthis];
            }
            return $newmag;

        }

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
