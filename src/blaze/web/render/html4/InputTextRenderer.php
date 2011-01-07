<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputTextRenderer extends \blaze\web\render\html4\BaseInputRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        parent::renderBegin($context, $component);
        $writer->write('<input');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();

        $writer->write(' type="' . $component->getType() . '"');
        $writer->write(' value="' . $this->getValue($context, $component) . '"');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('/>');
    }

}

?>
