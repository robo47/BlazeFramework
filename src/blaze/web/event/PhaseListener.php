<?php

namespace blaze\web\event;

use blaze\util\EventListener,
 blaze\web\application\BlazeContext,
 blaze\web\application\Lifecycle;

/**
 * Description of PhaseListener
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface PhaseListener extends EventListener {

    public function afterPhase(PhaseEvent $event);
    public function beforePhase(PhaseEvent $event);

    /**
     *
     * @return blaze\web\event\PhaseId
     */
    public function getPhaseId();

}
?>
