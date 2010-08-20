<?php

namespace blaze\web\render\html4;

/**
 * Description of OutputTextRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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

        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $converter = $component->getConverter();
        $tag = $this->getTypeTag($component);
        if ($tag != null)
            $writer->write('>');

        $value = $component->getValue();
        if ($value == null)
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
