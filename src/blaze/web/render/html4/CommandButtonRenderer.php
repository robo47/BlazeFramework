<?php

namespace blaze\web\render\html4;

/**
 * Description of CommandButtonRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class CommandButtonRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {
        
    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if ($context->getRequest()->getParameter($component->getClientId($context)) != null) {
            $component->setClicked(true);
            $component->queueEvent(new \blaze\web\event\ActionEvent($component));
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<input');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $disabled = $component->getDisabled();

        $writer->write(' type="submit" name="' . $component->getClientId($context) . '"');
        $writer->write(' value="' . $component->getValue() . '"');

        if ($disabled != null)
            $writer->write(' disabled="' . $disabled . '"');
        $writer->write('/>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
