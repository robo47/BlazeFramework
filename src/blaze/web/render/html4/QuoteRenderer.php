<?php

namespace blaze\web\render\html4;

/**
 * Description of QuoteRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class QuoteRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        if ($component->getBlock() === 'true')
            $writer->write('<blockquote');
        else
            $writer->write('<q');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $cite = $component->getCite();

        if ($cite != null)
            $writer->write(' cite="' . $cite . '"');
        $writer->write('>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</blockquote>');
    }

}

?>
