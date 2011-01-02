<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class BaseSelectRenderer extends \blaze\web\render\html4\BaseInputRenderer {

    protected function getValue(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component){
        $value = $component->getValue();
        if($value !== null)
                return $value;
        return '';
    }
}

?>
