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
class ValueChangeEvent extends BlazeEvent {

    private $oldValue;
    private $newValue;

    /**
     *
     * @param blaze\web\component\UIComponent $component
     */
    public function __construct(\blaze\web\component\UIComponent $component, $oldValue, $newValue) {
        parent::__construct($component);
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }

    public function isAppropriateListener(BlazeListener $blazeListener) {
        return $blazeListener instanceof ValueChangeEvent;
    }

    public function processListener(BlazeListener $blazeListener) {
        $blazeListener->processValueChange($this);
    }

    public function getOldValue() {
        return $this->oldValue;
    }

    public function getNewValue() {
        return $this->newValue;
    }

}

?>
