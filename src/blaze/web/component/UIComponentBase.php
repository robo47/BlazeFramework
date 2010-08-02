<?php
namespace blaze\web\component;

/**
 * Description of UIComponentBase
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIComponentBase implements UIComponent{
    protected $id;
    protected $parent;
    protected $children = array();
    protected $rendered;


     public function getChildren(){
         return $this->children;
     }
     public function addChildren(UIComponent $child){
         $this->children[] = $child;
     }
     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
     }

     public function getParent() {
         return $this->parent;
     }

     public function setParent($parent) {
         $this->parent = $parent;
     }

     public function getRendered() {
         return $this->rendered;
     }

     public function setRendered($rendered) {
         $this->rendered = $rendered;
     }


     /**
      * @return blaze\web\render\Renderer
      */
     public function getRenderer(\blaze\web\application\BlazeContext $context){
        return $context->getApplication()
                       ->getRenderKitFactory($this->getComponentFamily())
                       ->getRenderKit($context, $this->getComponentFamily())
                       ->getRenderer($this->getRendererId());
     }

     public function processDecodes(\blaze\web\application\BlazeContext $context){
         
     }
     public function processValidations(\blaze\web\application\BlazeContext $context){

     }
     public function processUpdates(\blaze\web\application\BlazeContext $context){

     }
     public function processApplication(\blaze\web\application\BlazeContext $context){

     }
     public function processRender(\blaze\web\application\BlazeContext $context){
        $renderer = $this->getRenderer($context);
        $renderer->renderBegin($context, $this);
        $renderer->renderChildren($context, $this);
        $renderer->renderEnd($context, $this);
     }
     
     public function decode(\blaze\web\application\BlazeContext $context){
         if($context == null) throw new \blaze\lang\NullPointerException();
         $renderer = $this->getRenderer($context);

         if($renderer != null)
             $renderer->decode ($context, $this);
     }
}

?>
