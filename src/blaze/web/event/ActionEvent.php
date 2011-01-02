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


 * @since   1.0


 */
class ActionEvent extends BlazeEvent {

    /**
     *
     * @param blaze\web\component\UIComponent $component
     */
    public function __construct(\blaze\web\component\UIComponent $component) {
        parent::__construct($component);
    }

    public function isAppropriateListener(BlazeListener $blazeListener) {
        return $blazeListener instanceof ActionListener;
    }

    public function processListener(BlazeListener $blazeListener) {
        $blazeListener->processAction($this);
    }
}

?>
