<?php
namespace blaze\web\render\html4;

/**
 * Description of PanelRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class PanelRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }

    private function getTypeTag(\blaze\web\component\UIComponent $component){
        $type = $component->getType();

        switch($type){
            case 'span':
                return'span';
            case 'div':
            default:
                return'div';
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<'.$this->getTypeTag($component));
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $writer->write('>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</'.$this->getTypeTag($component).'>');
    }


}

?>
