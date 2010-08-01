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
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
