<?php
namespace blaze\web\render\html4;

/**
 * Description of CommandButtonRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CommandButtonRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if($context->getRequest()->getParameter($component->getId()) != null){
                $component->setClicked(true);
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<input');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context, $component);
        $writer = $context->getResponse()->getWriter();
        $disabled = $component->getDisabled();

        $writer->write(' type="submit" name="'.$component->getId().'"');
        $writer->write(' value="'.$component->getValue().'"');
        
        if($disabled != null)
            $writer->write(' disabled="'.$disabled.'"');
    }

        public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
         $writer = $context->getResponse()->getWriter();
        $writer->write('/>');
    }


}

?>
