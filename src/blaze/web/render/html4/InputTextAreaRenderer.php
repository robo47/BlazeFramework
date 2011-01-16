<?php

namespace blaze\web\render\html4;

/**
 * Description of InputRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputTextAreaRenderer extends \blaze\web\render\html4\BaseInputRenderer {

    public function __construct() {
        
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        parent::renderBegin($context, $component);
        $writer->write('<textarea');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $rows = $component->getRows();
        $cols = $component->getCols();
        $value = $this->getValue($context, $component);

        if ($rows != null)
            $writer->write(' rows="' . $rows . '"');
        else
            $writer->write(' rows="3"');
        if ($cols != null)
            $writer->write(' cols="' . $cols . '"');
        else
            $writer->write(' cols="20"');

        $writer->write('>');
        if ($value !== null)
            $writer->write($value);
        $writer->write('</textarea>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

}

?>
