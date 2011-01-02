<?php
namespace blaze\web\render\html4;

/**
 * Description of BaseRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class BaseRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<base');
        $href = $component->getHref();
        $target = $component->getTarget();

        if($href != null)
            $writer->write(' href="'.$href.'"');
        if($target != null)
            $writer->write(' target="'.$target.'"');
        $writer->write('/>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }


}

?>
