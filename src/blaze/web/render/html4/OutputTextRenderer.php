<?php

namespace blaze\web\render\html4;

/**
 * Description of OutputTextRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class OutputTextRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    private function getTypeTag(\blaze\web\component\UIComponent $component) {
        $type = $component->getType();

        switch ($type) {
            case 'em':
                return'em';
            case 'strong':
                return'strong';
            case 'dfn':
                return'dfn';
            case 'code':
                return'code';
            case 'samp':
                return'samp';
            case 'kbd':
                return'kbd';
            case 'var':
                return'var';
            case 'cite':
                return'cite';
            case 'b':
                return'b';
            case 'h1':
                return'h1';
            case 'h2':
                return'h2';
            case 'h3':
                return'h3';
            case 'h4':
                return'h4';
            case 'h5':
                return'h5';
            case 'h6':
                return'h6';
            case 'none':
                return null;
            case 'p':
            default:
                return'p';
        }
    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $tag = $this->getTypeTag($component);
        if ($tag != null)
            $writer->write('<' . $tag);
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $tag = $this->getTypeTag($component);
        if ($tag != null)
            parent::renderAttributes($context, $component);

        $writer = $context->getResponse()->getWriter();
        $converter = $component->getConverter();
        if ($tag != null)
            $writer->write('>');

        $value = $component->getValue();
        if ($value === null)
            $value = $component->getLocalValue();

        if ($converter != null)
            $writer->write($converter->asString($context, $value));
        else
            $writer->write($value);
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $tag = $this->getTypeTag($component);
        if ($tag != null)
            $writer->write('</' . $tag . '>');
    }

}

?>
