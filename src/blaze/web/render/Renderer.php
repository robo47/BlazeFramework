<?php

namespace blaze\web\render;

/**
 * Description of Renderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class Renderer extends \blaze\lang\Object {

    public abstract function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);

    public abstract function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        foreach ($component->getChildren() as $child) {
            $child->processRender($context);
        }
    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
