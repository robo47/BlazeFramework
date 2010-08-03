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
class OutputTextRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<p');

        $styleClass = $component->getStyleClass();
        $style = $component->getStyle();
        $title = $component->getTitle();
        $converter = $component->getConverter();

        if($styleClass != null)
            $writer->write(' class="'.$styleClass.'"');
        if($title != null)
            $writer->write(' title="'.$title.'"');
        $writer->write('>');
        if($converter != null)
            $writer->write($converter->asString($context, $component->getLocalValue()));
        else
            $writer->write($component->getLocalValue());
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</p>');
    }


}

?>
