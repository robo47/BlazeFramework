<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputBooleanRenderer extends \blaze\web\render\html4\BaseInputRenderer {

    public function __construct() {
        
    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $val = $context->getRequest()->getParameter($component->getClientId($context));
        $component->setSubmittedValue($val === 'true');
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        parent::renderBegin($context, $component);
        $writer->write('<input');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $type = $component->getType();
        $disabled = $component->getDisabled();
        $checked = $this->getValue($context, $component);

        if ($type !== 'radio')
            $type = 'checkbox';

        $writer->write(' type="' . $type . '"');
        $writer->write(' value="true"');

        if ($checked === true)
            $writer->write(' checked="checked"');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('/>');
    }

}

?>
