<?php
namespace blaze\math;
use blaze\lang\Object;
use blaze\lang\Integer;

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
class BigDecimal extends Object {
    //Java-Implementation with BigInteger

    var $value;

    /**
     * The number of decimal digits in this BigDecimal, or 0 if the
     * number of digits are not known (lookaside information).  If
     * nonzero, the value is guaranteed correct.  Use the precision()
     * method to obtain and set the value if it might be 0.  This
     * field is mutable until set nonzero.
     *
     *
     */
    var $precision;

    public function __construct($value, $precision = 2, $signum = 1, $random = null){
        $this->precision = $precision;
        //if(is_string($value)){
            $this->value = new BigDecimal($value, $precision, $signum, $random);
        //}

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
            $len = strlen($ret);
            $sub = $len-$this->precision;
         return substr($ret, 0,$sub).substr($ret,$sub);
     }


}

?>


