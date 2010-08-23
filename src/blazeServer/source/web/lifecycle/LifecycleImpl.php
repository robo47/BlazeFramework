<?php

namespace blazeServer\source\web\lifecycle;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper,
        blaze\web\application\BlazeContext;

/**
 * The LifecycleImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class LifecycleImpl extends Object implements \blaze\web\lifecycle\Lifecycle {

    /**
     *
     * @var array[blaze\web\event\PhaseListener]
     */
    private $phaseListener = array();
    /**
     *
     * @var array[blazeServer\source\web\lifecycle\Phase]
     */
    private $phases = array();
    /**
     *
     * @var blazeServer\source\web\lifecycle\Phase
     */
    private $response;


    public function __construct() {
        $this->phases[] = new RestoreViewPhase();
        $this->phases[] = new ApplyRequestPhase();
        $this->phases[] = new ProcessValidationsPhase();
        $this->phases[] = new UpdateModelPhase();
        $this->phases[] = new InvokeApplicationPhase();
        $this->phases[] = $this->response = new RenderResponsePhase();
    }

    public function addPhaseListener(\blaze\web\event\PhaseListener $listener) {
        $this->phaseListener[] = $listener;
    }

    public function removePhaseListener(\blaze\web\event\PhaseListener $listener) {
        for ($i = 0; $i < count($this->phaseListener); $i++) {
            if ($this->phaseListener[$i] == $listener) {
                unset($this->phaseListener[$i]);
                return;
            }
        }
    }

    /**
     *
     * @param blaze\web\event\PhaseId $phaseId
     */
    public function processPhaseListener(\blaze\web\event\PhaseEvent $event, $before) {
        foreach ($this->phaseListener as $pl) {
            if ($pl->getPhaseId() == $event->getPhaseId()) {
                if ($before)
                    $pl->beforePhase($event);
                else
                    $pl->afterPhase($event);
            }
        }
    }

    /**
     * @return array[blaze\web\event\PhaseListener]
     */
    public function getPhaseListeners() {
        return $this->phaseListener;
    }

    public function execute(BlazeContext $context) {
        for ($i = 0; $i < count($this->phases) - 1; $i++) {
            if ($context->getDoRenderResponse() || $context->getResponseComplete()) {
                break;
            }
            \blaze\util\Logger::get()->log('Entering Phase '.\blaze\web\event\PhaseId::nameOf($this->phases[$i]->getId()));
            // PhaseListener are executed in the doPhase()
            $this->phases[$i]->doPhase($context, $this, $this->phaseListener);
            \blaze\util\Logger::get()->log('Exiting Phase '.\blaze\web\event\PhaseId::nameOf($this->phases[$i]->getId()));
        }
    }

    public function render(BlazeContext $context) {
        if (!$context->getResponseComplete()) {
            $this->response->doPhase($context, $this, $this->phaseListener);
        }
    }

}
?>
