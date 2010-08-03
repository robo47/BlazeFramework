<?php

namespace blazeServer\source\web\lifecycle;

use blaze\lang\Object,
 blaze\web\application\BlazeContext,
 blaze\web\lifecycle\Lifecycle,
 blaze\lang\Exception,
 blaze\web\event\PhaseEvent;

/**
 * The InvokeApplicationPhase
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class InvokeApplicationPhase extends Phase {

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
        $context->getViewRoot()->processApplication($context);
        // Action
        // 1. ActionListener 2. Action
//        $navigationMethod = null;
//        $actionDefs = $requViewClass->getMethod('getActionDefinitions')->invoke(null, null);
//
//        foreach ($actionDefs as $actionDef) {
//            $val = $request->getParameter($actionDef->getName());
//            if ($val != null) {
//                $actionListener = $actionDef->getActionListener();
//
//                if ($actionListener != null) {
//                    $actionListVal = String::asWrapper($actionListener);
//                    $valueExpr = new \blaze\web\el\Expression($actionListVal->substring(1, $actionListVal->length() - 1));
//                    $appContext->getElContext()->getELResolver()->invoke($valueExpr, null);
//                }
//
//                $action = $actionDef->getAction();
//
//                if ($action != null) {
//                    $actionVal = String::asWrapper($action);
//                    if ($actionVal->matches('/^{.*}$/')) {
//                        $valueExpr = new \blaze\web\el\Expression($actionVal->substring(1, $actionVal->length() - 1));
//                        $navigationMethod = $appContext->getElContext()->getELResolver()->invoke($valueExpr, null);
//                    } else {
//                        $navigationMethod = $actionVal;
//                    }
//                }
//            }
//        }
        
    }

    /**
     * @return the current {@link javax.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     *
     * @return blaze\web\event\PhaseId
     */
    public function getId() {
        return \blaze\web\event\PhaseId::INVOKE_APPLICATION;
    }

}
?>
