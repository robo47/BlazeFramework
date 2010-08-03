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
     /**
      * @param string|blaze\lang\String $id
      * @return blaze\web\component\UIComponent
      */
     public function setId($id);
     public function getParent();
     /**
      * @param blaze\web\component\UIComponent $parent
      * @return blaze\web\component\UIComponent
      */
     public function setParent($parent);
     public function getChildren();
     /**
      * @param blaze\web\component\UIComponent $child
      * @return blaze\web\component\UIComponent
      */
     public function addChild(UIComponent $child);
     public function getRendered();
     /**
      * @param boolean $rendered
      * @return blaze\web\component\UIComponent
      */
     public function setRendered($rendered);

     public static function create();

     /**
      * @return blaze\web\render\Renderer
      */
     public function getRenderer(\blaze\web\application\BlazeContext $context);
     public function getRendererId();
     public function getComponentFamily();

     public function processDecodes(\blaze\web\application\BlazeContext $context);
     public function processValidations(\blaze\web\application\BlazeContext $context);
     public function processUpdates(\blaze\web\application\BlazeContext $context);
     public function processApplication(\blaze\web\application\BlazeContext $context);
     public function processRender(\blaze\web\application\BlazeContext $context);
}

?>
