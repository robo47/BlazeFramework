<?php

namespace blaze\web\render\html4;

/**
 * Description of AreaRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class AreaRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<area');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $alt = $component->getAlt();
        $href = $component->getHref();
        $coords = $component->getCoords();
        $shape = $component->getShape();

        if ($href != null)
            $writer->write(' href="' . $href . '"');
        else
            $writer->write(' nohref="nohref"');
        if ($alt != null)
            $writer->write(' alt="' . $alt . '"');
        if ($coords != null)
            $writer->write(' coords="' . $coords . '"');
        if ($shape != null)
            $writer->write(' shape="' . $shape . '"');
        $writer->write('/>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
