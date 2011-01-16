<?php

namespace blaze\web\render;

/**
 * Description of Renderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface RendererDecorator {
    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component);
}

?>
