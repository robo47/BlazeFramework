<?php
namespace blaze\web\render\html4;

/**
 * Description of FormRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class FormRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if($context->getRequest()->getParameter('BLAZE_FORM_IDENTIFIER') == $component->getId()){
                $component->setSubmitted(true);
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<form');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context,  $component);
        $writer = $context->getResponse()->getWriter();
        $writer->write(' method="post" action=""><input type="hidden" name="BLAZE_FORM_IDENTIFIER" value="'.$component->getId().'"/>');
    }

        public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</form>');
    }


}

?>
