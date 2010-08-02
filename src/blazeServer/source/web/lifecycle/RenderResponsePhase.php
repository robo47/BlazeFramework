<?php

namespace blazeServer\source\web\lifecycle;

use blaze\lang\Object,
 blaze\web\application\BlazeContext,
 blaze\web\lifecycle\Lifecycle,
 blaze\lang\Exception,
 blaze\web\event\PhaseEvent;

/**
 * The RenderResponsePhase
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class RenderResponsePhase extends Phase {

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
        $oldViewId = $context->getViewRoot()->getViewId();
        $newView = $context->getViewHandler()->getRequestView($context);
        $newViewId = $newView->getViewId();

        if ($oldViewId != $newViewId) {
            $context->setView($newView);
        }
        $context->getRequest()->getSession()->setAttribute('blaze.view_restore', $context->getViewRoot());
        $context->getViewRoot()->processRender($context);
    }

    /**
     * @return the current {@link javax.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     *
     * @return blaze\web\event\PhaseId
     */
    public function getId(){
        return \blaze\web\event\PhaseId::RENDER_RESPONSE;
    }



}
?>
