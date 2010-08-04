<?php

namespace blaze\web\render\html4;

/**
 * Description of ImageRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ImageRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();

        $writer->write('<img');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $src = $component->getSrc();
        $alt = $component->getAlt();
        $height = $component->getHeight();
        $width = $component->getWidth();
        $useMap = $component->getUseMap();

        if ($src != null)
            $writer->write(' src="' . $src . '"');
        if ($alt != null)
            $writer->write(' alt="' . $alt . '"');
        if ($height != null)
            $writer->write(' height="' . $height . '"');
        if ($width != null)
            $writer->write(' width="' . $width . '"');
        if ($useMap == true)
            $writer->write(' usemap="#' . $component->getId() . 'Map"');
        $writer->write('/>');
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        if ($component->getUseMap() == true) {
            $writer = $context->getResponse()->getWriter();
            $writer->write('<map name="' . $component->getId() . 'Map">');
            parent::renderChildren($context, $component);
            $writer->write('</map>');
        } else {
            parent::renderChildren($context, $component);
        }
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
    }

}
?>
