<?php

namespace blaze\web\render\html4;

/**
 * Description of HeadRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class HeadRenderer extends \blaze\web\render\Renderer {

    public function __construct() {

    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<head>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</head>');
    }

}

?>
