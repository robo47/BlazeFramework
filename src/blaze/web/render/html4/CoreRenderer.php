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
abstract class CoreRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();

        $id = $component->getClientId($context);
        $styleClass = $component->getStyleClass();
        $style = $component->getStyle();
        $title = $component->getTitle();

        if($id != null)
            $writer->write(' id="'.$id.'"');
        if($title != null)
            $writer->write(' title="'.$title.'"');
        if($styleClass != null)
            $writer->write(' class="'.$styleClass.'"');
        if($style != null)
            $writer->write(' style="'.$style.'"');
    }


}

?>
