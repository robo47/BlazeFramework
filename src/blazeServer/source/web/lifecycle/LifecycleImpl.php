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


 * @since   1.0

 */
class LifecycleImpl extends Object implements \blaze\web\lifecycle\Lifecycle {

    /**
     *
     * @var array[blaze\web\event\PhaseListener]
     */
    private $phaseListener;
    /**
     *
     * @var array[blazeServer\source\web\lifecycle\Phase]
     */
    private $phases;
    /**
     *
     * @var blazeServer\source\web\lifecycle\Phase
     */
    private $response;


    public function __construct() {
        $this->phaseListener = new \blaze\collections\map\HashMap();
        $this->phases = new \blaze\collections\lists\ArrayList();
        $this->phases->add(new RestoreViewPhase());
        $this->phases->add(new ApplyRequestPhase());
        $this->phases->add(new ProcessValidationsPhase());
        $this->phases->add(new UpdateModelPhase());
        $this->phases->add(new InvokeApplicationPhase());
        $this->phases->add($this->response = new RenderResponsePhase());
    }

    public function addPhaseListener(\blaze\web\event\PhaseListener $listener, $uri = null) {
        if($uri === null)
            $uri = '/*';
        $this->phaseListener->put($uri, $listener);
    }

    public function removePhaseListener(\blaze\web\event\PhaseListener $listener, $uri = null) {
        if($uri !== null){
            $this->phaseListener->remove($uri);
    }else{
        $iter = $this->phaseListener->getIterator();

        while($iter->hasNext()){
            $entry = $iter->next();

            if($entry->getValue() == $listener){
                    $iter->remove();
                    return;
            }
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
        for($i = 0; $i < $this->phases->count() - 1; $i++) {
            if ($context->getDoRenderResponse() || $context->getResponseComplete()) {
                break;
            }
            // PhaseListener are executed in the doPhase()
            $this->phases->get($i)->doPhase($context, $this, $this->phaseListener);
        }
    }

    public function render(BlazeContext $context) {
        if (!$context->getResponseComplete()) {
            $this->response->doPhase($context, $this, $this->phaseListener);
        }
    }

}
?>
