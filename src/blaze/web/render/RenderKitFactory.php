<?php
namespace blaze\web\render;

/**
 * Description of RenderKitFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface RenderKitFactory extends \blaze\lang\Singleton{
    public function addRenderKit($componentFamily, $renderKitId, RenderKit $renderKit);
    /**
     * @return blaze\web\render\RenderKit
     */
     public function getRenderKit(\blaze\web\application\BlazeContext $context, $componentFamily);
}

?>
