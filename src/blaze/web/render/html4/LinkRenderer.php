<?php
namespace blaze\web\render\html4;

/**
 * Description of LinkRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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

        if($href != null)
            $writer->write(' href="'.$href.'"');
        $writer->write('>');
        $writer->write($component->getValue());
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</a>');
    }


}

?>
