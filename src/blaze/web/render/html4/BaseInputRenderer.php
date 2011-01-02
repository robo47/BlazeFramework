<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class BaseInputRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $val = $context->getRequest()->getParameter($component->getClientId($context));
        if ($val != null) {
            $component->setSubmittedValue($val);
        }
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context, $component);
        $writer = $context->getResponse()->getWriter();
        $disabled = $component->getDisabled();

        $writer->write(' name="'.$component->getClientId($context).'"');

        if($disabled === true)
            $writer->write(' disabled="disabled"');
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $label = $component->getLabel();
        if ($label != null) {
            $writer->write('<label for="' . $component->getClientId($context) . '">');
            $writer->write($label);
            $writer->write('</label>');
        }
    }

    protected function getValue(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component){
        $value = $component->getSubmittedValue();
        if($value !== null)
                return $value;
        $value = $component->getLocalValue();
        if($value !== null)
                return $value;
        $value = $component->getValue();
        if($value !== null)
                return $value;
        return '';
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

}

?>
