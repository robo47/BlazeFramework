<?php
namespace blaze\web\render;

/**
 * Description of RenderKitFactoryImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class RenderKitFactoryImpl {
    private $renderKits = array();

    private function __construct(){
        
    }

    public function addRenderKit($componentFamily, $renderKitId, RenderKit $renderKit){
        $this->renderKits[$componentFamily][$renderKitId] = $renderKit;
    }
     public function getRenderKit(\blaze\web\application\BlazeContext $context, $componentFamily){
        $context->getRequest()->getUserAgent()->getBrowser();
     }

     public static function getInstance(){
         if(self::$instance == null)
             self::$instance = new self();
         return self::$instance;
     }
}

?>
