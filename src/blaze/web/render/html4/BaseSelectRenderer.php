<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
