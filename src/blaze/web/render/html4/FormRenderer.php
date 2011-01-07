<?php

namespace blaze\web\render\html4;

/**
 * Description of FormRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class FormRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {
        
    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if ($context->getRequest()->getParameter('BLAZE_FORM_IDENTIFIER') == $component->getClientId($context)) {
            $component->setSubmitted(true);
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<form');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $writer->write(' method="post" action=""><div style="display: none;"><input type="hidden" name="BLAZE_FORM_IDENTIFIER" value="' . $component->getClientId($context) . '"/></div>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</form>');
    }

}

?>
