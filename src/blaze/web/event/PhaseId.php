<?php
namespace blaze\web\event;

/**
 * Description of PhaseId
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class PhaseId extends \blaze\lang\Enum{

     const ANY_PHASE = 0;
     const RESTORE_VIEW = 1;
     const APPLY_REQUEST = 2;
     const PROCESS_VALIDATION = 3;
     const UPDATE_MODEL = 4;
     const INVOKE_APPLICATION = 5;
     const RENDER_RESPONSE = 6;
}

?>
