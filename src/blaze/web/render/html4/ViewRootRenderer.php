<?php
namespace blaze\web\render\html4;

/**
 * Description of ViewRootRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ViewRootRenderer extends \blaze\lang\Object implements \blaze\web\render\Renderer{

    public function __construct(){

    }
    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml">');
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        foreach($component->getChildren() as $child){
            $renderer = $child->getRenderer();
            $renderer->renderBegin($context, $child);
            $renderer->renderChildren($context, $child);
            $renderer->renderEnd($context, $child);
        }
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</html>');
    }


}

?>
