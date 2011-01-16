<?php

namespace blaze\web\event;

use blaze\util\EventObject,
 blaze\web\application\BlazeContext,
 blaze\web\lifecycle\Lifecycle;

/**
 * Description of PhaseEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class PhaseEvent extends EventObject {

    /**
     *
     * @var blaze\web\application\BlazeContext
     */
    private $context;
    /**
     *
     * @var blaze\web\event\PhaseId
     */
    private $phaseId;

    /**
     *
     * @param blaze\web\application\BlazeContext $context
     * @param blaze\web\event\PhaseId $phaseId
     * @param blaze\web\application\Lifecycle $lifecycle
     */
    public function __construct(BlazeContext $context, $phaseId, Lifecycle $lifecycle) {
        parent::__construct($lifecycle);
        $this->context = $context;
        $this->phaseId = $phaseId;
    }

    /**
     *
     * @return blaze\web\application\BlazeContext
     */
    public function getBlazeContext() {
        return $this->context;
    }

    /**
     *
     * @return blaze\web\event\PhaseId
     */
    public function getPhaseId() {
        return $this->phaseId;
    }

}

?>
