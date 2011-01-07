<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of Address
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class UIEvent extends \blaze\web\component\UIComponentBase {

    private $effects = array();

    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($child instanceof UIEffect)
            $this->effects[] = $child;
        else
            ; // Impossible because of XSD
//        return parent::addChild($child);
    }

    public function getEffects() {
        return $this->effects;
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {

    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {

    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {

    }

}

?>
