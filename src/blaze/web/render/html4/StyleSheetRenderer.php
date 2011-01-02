<?php
namespace blaze\web\render\html4;

/**
 * Description of BaseRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class StyleSheetRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<link rel="stylesheet" type="text/css" media="screen"');
        $href = $component->getHref();
        $charset = $component->getCharset();

        if($href != null)
            $writer->write(' href="'.$href.'"');
        if($charset != null)
            $writer->write(' charset="'.$charset.'"');
        else
            $writer->write(' charset="utf-8"');
        $writer->write('/>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
    }


}

?>
