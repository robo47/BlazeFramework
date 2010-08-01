<?php
namespace blaze\web\event;

/**
 * Description of PhaseId
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class PhaseId extends \blaze\lang\Enum{

     const ANY_PHASE = 0;
     const RESTORE_VIEW = 1;
     const APPLY_REQUEST = 2;
     const PROCESS_VALIDATION = 3;
     const UPDATE_MODEL = 4;
     const INVOKE_APPLICATION = 5;
     const RENDER_RESPONSE = 6;

     public static function getClassName() {
         return __CLASS__;
     }

}

?>
