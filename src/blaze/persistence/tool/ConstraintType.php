<?php
namespace blaze\persistence\tool;
use blaze\lang\Enum;

/**
 * Description of ConstraintType
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ConstraintType extends Enum {

    const PRIMARY = 0,
          FOREIGN = 1,
          UNIQUE  = 2;
    
     public function getClassName(){
        return __CLASS__;
     }
}

?>
