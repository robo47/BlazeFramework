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


 * @since   1.0

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
    public function execute(BlazeContext $context) {
        $oldViewId = $context->getRequest()->getSession(true)->getAttribute('blaze.view_restore');
        if($oldViewId != null)
            $oldViewId = $oldViewId->getViewId();
        $actViewId = $context->getViewRoot()->getViewId();
        $requestedView = $context->getViewHandler()->getRequestView($context);

        if (!$context->getDoRenderResponse() && 
            !$context->getNavigated() &&
            $oldViewId == $actViewId) {
            if ($requestedView == null) {
                $context->getResponse()->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND);
                $context->responseComplete();
            } else {
                $requestedViewId = $requestedView->getViewId();

                if ($requestedViewId != $actViewId) {
                    $context->setViewRoot($requestedView);
                    // clean up the el view scope
                    $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_VIEW)->resetValues($context);
                }
            }
        }

        $context->getRequest()->getSession()->setAttribute('blaze.view_restore', $context->getViewRoot());
        if (!$context->getResponseComplete())
            $context->getViewRoot()->processRender($context);
        
    }

    /**
     * @return the current {@link javax.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     *
     * @return blaze\web\event\PhaseId
     */
    public function getId() {
        return \blaze\web\event\PhaseId::RENDER_RESPONSE;
    }

}

?>
