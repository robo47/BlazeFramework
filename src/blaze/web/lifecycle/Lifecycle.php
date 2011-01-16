<?php

namespace blaze\web\lifecycle;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper,
        blaze\web\application\BlazeContext;

/**
 * The Lifecycle
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 * @see     http://www.javabeat.net/articles/54-request-processing-lifecycle-phases-in-jsf-1.html

 */
interface Lifecycle {

    public function addPhaseListener(\blaze\web\event\PhaseListener $listener, $uri = null);
    public function removePhaseListener(\blaze\web\event\PhaseListener $listener);
    public function execute(BlazeContext $context);
    /**
     * @return array[blaze\web\event\PhaseListener]
     */
    public function getPhaseListeners();
    public function render(BlazeContext $context);

}
?>
