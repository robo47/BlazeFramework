<?php

namespace blazeServer\source\web\lifecycle;

use blaze\lang\Object,
 blaze\web\application\BlazeContext,
 blaze\web\lifecycle\Lifecycle,
 blaze\lang\Exception,
 blaze\web\event\PhaseEvent;

/**
 * The Phase
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class RestoreViewPhase extends Phase {

    
    /**
     * <p>Perform all state transitions required by the current phase of the
     * request processing {@link javax.faces.lifecycle.Lifecycle} for a
     * particular request. </p>
     *
     * @param context FacesContext for the current request being processed
     * @throws FacesException if a processing error occurred while
     *                        executing this phase
     */
    public function execute(BlazeContext $context){
        $context->getViewHandler()->restoreOrCreateView($context);
    }

    /**
     * @return the current {@link javax.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     *
     * @return blaze\web\event\PhaseId
     */
    public function getId(){
        return \blaze\web\event\PhaseId::RESTORE_VIEW;
    }

// ------------------------------------------------------- Protected Methods

    

}
?>
