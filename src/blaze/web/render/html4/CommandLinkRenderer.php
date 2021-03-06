<?php

namespace blaze\web\render\html4;

/**
 * Description of CommandLinkRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class CommandLinkRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {
        
    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if ($context->getRequest()->getParameter('BLAZE_COMMAND_IDENTIFIER') == $component->getClientId($context)) {
            $component->setClicked(true);
            $component->queueEvent(new \blaze\web\event\ActionEvent($component));
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<script type="text/javascript">function commandLinkClick(link){ var parentForm=link.parentNode; while(parentForm.nodeName != "FORM"){ parentForm=parentForm.parentNode; } var identifier = document.createElement("input"); identifier.type="hidden"; identifier.name="BLAZE_COMMAND_IDENTIFIER"; identifier.value=link.id; parentForm.appendChild(identifier); parentForm.submit(); return false;} </script>');
        $writer->write('<a');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $writer->write(' onclick="return commandLinkClick(this)" href="#"');
        $writer->write('>');
        $writer->write($component->getValue());
        $writer->write('</a>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
