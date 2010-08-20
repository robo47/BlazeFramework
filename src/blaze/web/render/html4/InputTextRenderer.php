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
class InputTextRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $val = $context->getRequest()->getParameter($component->getId());
        if($val != null){
                $component->setSubmittedValue($val);
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $label = $component->getLabel();
        if($label != null){
            $writer->write('<label for="'.$component->getId().'">');
            $writer->write($label);
            $writer->write('</label>');
        }
        $writer->write('<input');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context, $component);
        $writer = $context->getResponse()->getWriter();
        $disabled = $component->getDisabled();
        
        $writer->write(' type="'.$component->getType().'" name="'.$component->getId().'"');
        $writer->write(' value="'.$component->getLocalValue().'"');
        
        if($disabled != null)
            $writer->write(' disabled="'.$disabled.'"');
    }

        public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
         $writer = $context->getResponse()->getWriter();
        $writer->write('/>');
    }


}

?>
