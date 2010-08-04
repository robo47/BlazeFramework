<?php
namespace blaze\web\render;

/**
 * Description of Renderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class Renderer extends \blaze\lang\Object{
     public abstract function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);
     public abstract function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);
     public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component){
         
     }
     public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component){
         foreach($component->getChildren() as $child){
            $renderer = $child->getRenderer($context);
            $renderer->renderBegin($context, $child);
            $renderer->renderAttributes($context, $child);
            $renderer->renderChildren($context, $child);
            $renderer->renderEnd($context, $child);
        }
     }
     
     public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }
}

?>
