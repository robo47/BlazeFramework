<?php

namespace blaze\web\event;

use blaze\util\EventObject,
 blaze\web\application\BlazeContext,
 blaze\web\lifecycle\Lifecycle;

/**
 * Description of BlazeEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class BlazeEvent extends EventObject {

    /**
     *
     * @var blaze\web\event\PhaseId
     */
    private $phaseId;

    /**
     *
     * @param blaze\web\component\UIComponent $component
     */
    public function __construct(\blaze\web\component\UIComponent $component, $phaseId = null) {
        parent::__construct($component);
        if($phaseId == null)
            $phaseId = PhaseId::ANY_PHASE;
        $this->phaseId = $phaseId;
    }

  public abstract function isAppropriateListener(BlazeListener $blazeListener);

  public abstract function processListener(BlazeListener $blazeListener);
    /**
     *
     * @return blaze\web\component\UIComponent
     */
    public function getComponent() {
        return $this->getSource();
    }

    /**
     *
     * @return blaze\web\event\PhaseId
     */
    public function getPhaseId() {
        return $this->phaseId;
    }
    
    /**
     *
     * @param blaze\web\event\PhaseId $phaseId
     */
    public function setPhaseId($phaseId) {
        $this->phaseId = $phaseId;
    }



}
?>
