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
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class Phase extends Object {

    /**
     * Performs PhaseListener processing and invokes the execute method
     * of the Phase.
     * @param blaze\web\application\BlazeContext $context the FacesContext for the current request
     * @param blaze\web\lifecycle\Lifecycle $lifecycle the lifecycle for this request
     * @param array[blaze\web\event\PhaseListener] $listeners
     */
    public function doPhase(BlazeContext $context, Lifecycle $lifecycle, \blaze\collections\Map $listeners) {
        $context->setCurrentPhaseId($this->getId());
        $event = null;
        if ($listeners->count() != 0) {
            $event = new PhaseEvent($context, $this->getId(), $lifecycle);
        }

// start timing - include before and after phase processing
//        Timer timer = Timer.getInstance();
//        if (timer != null) {
//            timer.startTiming();
//        }

        try {
            if ($event != null)
                $this->handleBeforePhase($context, $listeners, $event);
            if (!$this->shouldSkip($context)) {
                $this->execute($context);
            }
        } catch (Exception $e) {
            $this->queueException($context, $e);
        }
        try {
            if ($event != null)
                $this->handleAfterPhase($context, $listeners, $event);
        } catch (Exception $e) {
            $this->queueException($context, $e);
        }
// stop timing
//            if (timer != null) {
//                timer.stopTiming();
//                timer.logResult(
//                      "Execution time for phase (including any PhaseListeners) -> "
//                      + this.getId().toString());
//            }
        //$context->getExceptionHandler()->handle();
    }

    /**
     * <p>Perform all state transitions required by the current phase of the
     * request processing {@link javax.faces.lifecycle.Lifecycle} for a
     * particular request. </p>
     *
     * @param context FacesContext for the current request being processed
     * @throws FacesException if a processing error occurred while
     *                        executing this phase
     */
    public abstract function execute(BlazeContext $context);

    /**
     * @return the current {@link javax.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     *
     * @return blaze\web\event\PhaseId
     */
    public abstract function getId();

// ------------------------------------------------------- Protected Methods

    /**
     *
     * @param BlazeContext $ctx
     * @param Exception $e
     * @param string|blaze\lang\string $booleanKey
     * @todo Think about what to do with this method
     */
    protected function queueException(BlazeContext $ctx, Exception $e, $booleanKey = null) {

//        ExceptionQueuedEventContext extx = new ExceptionQueuedEventContext($ctx, $e);
//        if (booleanKey != null) {
//            extx.getAttributes().put(booleanKey, Boolean.TRUE);
//        }
//        ctx.getApplication().publishEvent(ctx, ExceptionQueuedEvent.class, extx);

        throw $e;
    }

    /**
     * Handle <code>afterPhase</code> <code>PhaseListener</code> events.
     * @param blaze\web\application\BlazeContext $context the FacesContext for the current request
     * @param array[blaze\web\event\PhaseListener] $listenersIterator a ListIterator for the PhaseListeners that need
     *  to be invoked
     * @param blaze\web\event\PhaseEvent $event the event to pass to each of the invoked listeners
     */
    protected function handleAfterPhase(BlazeContext $context, \blaze\collections\Map $listeners, PhaseEvent $event) {

//try {
//Flash flash = context.getExternalContext().getFlash();
//flash.doPostPhaseActions(context);
//} catch (UnsupportedOperationException uoe) {
//if (LOGGER.isLoggable(Level.FINE)) {
//LOGGER.fine("ExternalContext.getFlash() throw UnsupportedOperationException -> Flash unavailable");
//}
//}
        $requestUri = $context->getRequest()->getRequestURI()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new \blaze\lang\String('/' . $requestUri->toNative());

        foreach ($listeners as $pattern => $listener) {
            if (($this->getId() == $listener->getPhaseId() || \blaze\web\event\PhaseId::ANY_PHASE == $listener->getPhaseId()) && $this->matchesPattern($requestUri, $pattern)) {
                try {
                    $listener->afterPhase($event);
                } catch (Exception $e) {
                    queueException($context, $e); //, ExceptionQueuedEventContext.IN_AFTER_PHASE_KEY);
                    return;
                }
            }
        }
    }

    /**
     * Handle <code>beforePhase</code> <code>PhaseListener</code> events.
     * @param blaze\web\application\BlazeContext $context the FacesContext for the current request
     * @param array[blaze\web\event\PhaseListener] $listenersIterator a ListIterator for the PhaseListeners that need
     *  to be invoked
     * @param blaze\web\event\PhaseEvent $event the event to pass to each of the invoked listeners
     */
    protected function handleBeforePhase(BlazeContext $context, \blaze\collections\Map $listeners, PhaseEvent $event) {

        //try {
        //Flash flash = context.getExternalContext().getFlash();
        //flash.doPrePhaseActions(context);
        //} catch (UnsupportedOperationException uoe) {
        //if (LOGGER.isLoggable(Level.FINE)) {
        //LOGGER.fine("ExternalContext.getFlash() throw UnsupportedOperationException -> Flash unavailable");
        //}
        //}
        //RequestStateManager.clearAttributesForPhase(context,
        // context.getCurrentPhaseId());
        $requestUri = $context->getRequest()->getRequestURI()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new \blaze\lang\String('/' . $requestUri->toNative());

        foreach ($listeners as $pattern => $listener) {
            if (($this->getId() == $listener->getPhaseId() || \blaze\web\event\PhaseId::ANY_PHASE == $listener->getPhaseId()) && $this->matchesPattern($requestUri, $pattern)) {
                try {
                    $listener->beforePhase($event);
                } catch (Exception $e) {
                    $this->queueException($context, $e); //, ExceptionQueuedEventContext.IN_BEFORE_PHASE_KEY);
                    // move the iterator pointer back one
                    //if (listenersIterator.hasPrevious()) {
                    //listenersIterator.previous();
                    //}
                    return;
                }
            }
        }
    }

// --------------------------------------------------------- Private Methods

    private function matchesPattern($uri, $pattern){
        return preg_match('/^' . str_replace(array('/', '*'), array('\/', '.*'), $pattern) . '$/', $uri) === 1;
    }
    /**
     * @param context the FacesContext for the current request
     * @return <code>true</code> if <code>FacesContext.responseComplete()</code>
     *  or <code>FacesContext.renderResponse()</code> and the phase is not
     *  RENDER_RESPONSE, otherwise return <code>false</code>
     * 
     * @return boolean
     */
    private function shouldSkip(BlazeContext $context) {
        if ($context->getResponseComplete()) {
            return true;
        } else if ($context->getDoRenderResponse() &&
                \blaze\web\event\PhaseId::RENDER_RESPONSE != $this->getId()) {
            return true;
        } else {
            return false;
        }
    }

}

?>
