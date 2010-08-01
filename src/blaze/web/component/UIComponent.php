<?php
namespace blaze\web\component;

/**
 * Description of UIComponent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface UIComponent {
     public function getId();
     public function setId($id);
     public function getParent();
     public function setParent($parent);
     public function getChildren();
     public function addChildren(UIComponent $child);
     public function getRendered();
     public function setRendered($rendered);
     /**
      * @return blaze\web\render\Renderer
      */
     public function getRenderer(\blaze\web\application\BlazeContext $context);

     public function processDecodes(\blaze\web\application\BlazeContext $context);
     public function processValidations(\blaze\web\application\BlazeContext $context);
     public function processUpdates(\blaze\web\application\BlazeContext $context);
     public function processApplication(\blaze\web\application\BlazeContext $context);
     public function processRender(\blaze\web\application\BlazeContext $context);
     
     public function decode(\blaze\web\application\BlazeContext $context);
}

?>
