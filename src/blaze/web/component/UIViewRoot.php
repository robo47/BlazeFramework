<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of UIViewRoot
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class UIViewRoot extends \blaze\web\component\UIComponentBase implements NamingContainer {

    private $viewId;
    private $events = array();
    private $idSet = array();
    private $idCount = 0;

    public function __construct() {

    }

    public static function create() {
        return new UIViewRoot();
    }

    public function queueEvent(\blaze\web\event\BlazeEvent $event) {
        $this->events[] = $event;
    }

    private function clearEvents() {
        $this->events = array();
    }

    public function getViewId() {
        return $this->viewId;
    }

    public function addComponentToCache(UIComponent $component) {
        $id = $component->getId();
        if (isset($this->idSet[$id]))
            throw new \blaze\web\application\BlazeException('Component has an already existing id: ' . $id);
        $this->idSet[$id] = $component;
    }

    public function findComponent($id) {
        if (isset($this->idSet[$id]))
            return $this->idSet[$id];
        return null;
    }

    public function createUniqueId() {
        return 'id' . ($this->idCount++);
    }

    /**
     *
     * @param string|blaze\lang\String $viewId
     * @return blaze\web\component\UIViewRoot 
     */
    public function setViewId($viewId) {
        $this->viewId = $viewId;
        return $this;
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'ViewRootRenderer';
    }

    /**
     *
     * @param \blaze\web\event\PhaseId $phaseId
     */
    private function broadcastEvents(\blaze\web\application\BlazeContext $context, $phaseId) {
        foreach ($this->events as $event) {
            if ($event->getPhaseId() == $phaseId ||
                    $event->getPhaseId() == \blaze\web\event\PhaseId::ANY_PHASE) {
                $component = $event->getSource();
                $component->processEvent($context, $event);
            }
        }
    }

    public function processEvents(\blaze\web\application\BlazeContext $context) {
        $this->broadcastEvents($context, \blaze\web\event\PhaseId::INVOKE_APPLICATION);
        if ($context->getResponseComplete() || $context->getDoRenderResponse())
            $this->clearEvents();
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        parent::processDecodes($context);
        $this->broadcastEvents($context, \blaze\web\event\PhaseId::APPLY_REQUEST);
        if ($context->getResponseComplete() || $context->getDoRenderResponse())
            $this->clearEvents();
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        parent::processUpdates($context);
        $this->broadcastEvents($context, \blaze\web\event\PhaseId::UPDATE_MODEL);
        if ($context->getResponseComplete() || $context->getDoRenderResponse())
            $this->clearEvents();
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        parent::processValidations($context);
        $this->broadcastEvents($context, \blaze\web\event\PhaseId::PROCESS_VALIDATION);
        if ($context->getResponseComplete() || $context->getDoRenderResponse())
            $this->clearEvents();
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        parent::processRender($context);
        $this->clearEvents();
    }

}

?>
