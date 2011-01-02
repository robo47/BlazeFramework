<?php
namespace blaze\web\render\html4;

/**
 * Description of LinkRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class LinkRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<a');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes( $context,  $component);
        $writer = $context->getResponse()->getWriter();
        $value = $component->getValue();
        $href = $component->getHref();
        $target = $component->getTarget();
        $rel = $component->getRel();

        if($href != null)
            $writer->write(' href="'.$href.'"');
        if($rel != null)
            $writer->write(' rel="'.$rel.'"');
        if($target != null)
            $writer->write(' target="'.$target.'"');
        $writer->write('>');
        $writer->write($component->getValue());
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</a>');
    }


}

?>
