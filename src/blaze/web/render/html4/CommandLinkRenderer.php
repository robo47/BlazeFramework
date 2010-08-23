<?php
namespace blaze\web\render\html4;

/**
 * Description of CommandLinkRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CommandLinkRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if($context->getRequest()->getParameter('BLAZE_COMMAND_IDENTIFIER') == $component->getClientId($context)){
                $component->setClicked(true);
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<script type="text/javascript">function commandLinkClick(link){ var parentForm=link.parentNode; while(parentForm.nodeName != "FORM"){ parentForm=parentForm.parentNode; } var identifier = document.createElement("input"); identifier.type="hidden"; identifier.name="BLAZE_COMMAND_IDENTIFIER"; identifier.value=link.id; parentForm.appendChild(identifier); parentForm.submit(); return false;} </script>');
        $writer->write('<a');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context,  $component);
        $writer = $context->getResponse()->getWriter();
        $writer->write(' onclick="return commandLinkClick(this)" href="#"');
        $writer->write('>');
        $writer->write($component->getValue());
    }

        public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</a>');
    }


}

?>
