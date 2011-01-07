<?php

namespace blaze\web\render;

/**
 * Description of RenderKitFactoryImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class RenderKitFactoryEventImpl extends \blaze\lang\Object {

    private static $instance;
    private $renderKits = array();

    private function __construct() {
        
    }

    public function addRenderKit($componentFamily, $renderKitId, RenderKit $renderKit) {
        $this->renderKits[$componentFamily][$renderKitId] = $renderKit;
    }

    public function getRenderKit(\blaze\web\application\BlazeContext $context, $componentFamily) {
        return $this->renderKits[$componentFamily]['js'];
    }

    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new self();
        return self::$instance;
    }

}

?>
