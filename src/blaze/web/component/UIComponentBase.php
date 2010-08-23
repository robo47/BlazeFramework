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
abstract class UIComponentBase extends \blaze\lang\Object implements UIComponent {

    private $id;
    private $clientId;
    private $parent;
    private $children = array();
    private $rendered;
    private $listeners = array();

    public function getChildren() {
        return $this->children;
    }

    public function addChild(\blaze\web\component\UIComponent $child) {
        $this->children[] = $child->setParent($this);
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->checkId($id);
        $this->id = $id;
        $this->clientId = null;
        return $this;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent(\blaze\web\component\UIComponent $parent) {
        $this->parent = $parent;
        return $this;
    }

    public function getRendered() {
        if($this->rendered == null)
                return true;
        return $this->getResolvedExpression($this->rendered);
    }

    public function setRendered($rendered) {
        $this->rendered = new \blaze\web\el\Expression($rendered);
        return $this;
    }

    public function queueEvent(\blaze\web\event\BlazeEvent $event) {
        $parent = $this->getParent();

        if($parent == null)
            throw new \blaze\lang\IllegalArgumentException('Component has no ViewRoot');
        $parent->queueEvent($event);
    }

    public function getClientId(\blaze\web\application\BlazeContext $context){
        if($this->clientId != null) return $this->clientId;
        if($this->getId() == null)
            $this->id = $context->getViewRoot()->createUniqueId();

        $container = $this;

        while($container != null && !$container instanceof NamingContainer){
            $container = $container->getParent();
        }

        if($container == null || $container == $this){
            $this->clientId = $this->id;
        }else{
            $this->clientId = $container->getClientId($context).NamingContainer::CONTAINER_SEPARATOR.$this->id;
        }

        return $this->clientId;
    }

    protected function getRoot(){
        $parent = $this;

        while(true){
            $comp = $parent->getParent();

            if($comp == null)
                return $parent;
            $parent = $comp;
        }
    }

    protected function addBlazeListener(\blaze\web\event\BlazeListener $listener){
        $this->listeners[] = $listeners;
    }

    protected function getBlazeListeners(){
        return $this->listeners;
    }

    protected function removeBlazeListener(\blaze\web\event\BlazeListener $listener){
        $key = array_search($listener, $this->listeners);
        if($key !== false) unset($this->listeners[$key]);
    }

    protected function getResolvedExpression(\blaze\web\el\Expression $expr = null){
        if($expr == null)
            return null;
        if(!$expr->isValid())
                return $expr->getExpressionString();
        $context = \blaze\web\application\BlazeContext::getCurrentInstance();
        return $expr->getValue($context);
    }

    protected function invokeResolvedExpression(\blaze\web\el\Expression $expr = null){
        if($expr == null)
            return null;
        if(!$expr->isValid())
                return $expr->getExpressionString();
        $context = \blaze\web\application\BlazeContext::getCurrentInstance();
        return $expr->invoke($context, array());
    }

    /**
     * @return blaze\web\render\Renderer
     */
    public function getRenderer(\blaze\web\application\BlazeContext $context) {
        return $context->getApplication()
                ->getRenderKitFactory($this->getComponentFamily())
                ->getRenderKit($context, $this->getComponentFamily())
                ->getRenderer($this->getRendererId());
    }

    public function processEvent(\blaze\web\event\BlazeEvent $event) {
        foreach($this->listeners as $listener){

        }
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        $renderer = $this->getRenderer($context);
        $renderer->decode($context, $this);

        foreach ($this->children as $child)
            $child->processDecodes($context);
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processValidations($context);
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processUpdates($context);
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processApplication($context);
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        $renderer = $this->getRenderer($context);

        $renderer->renderBegin($context, $this);
        $renderer->renderAttributes($context, $this);
        $renderer->renderChildren($context, $this);
        $renderer->renderEnd($context, $this);
    }

    private function checkId($id){
        if($id == null)
            return;
        $str = \blaze\lang\String::asNative($id);
        if(strlen($str) == 0)
            throw new \blaze\lang\IllegalArgumentException('Component id must have a length of at least one character');

        $firstChar = $str[0];
        if($firstChar != '_' && !\blaze\lang\Character::isLetter($firstChar))
            throw new \blaze\lang\IllegalArgumentException('Component id\'s first character must be a letter or underscore (_) and not '.$firstChar);

        if(!preg_match('/^..[a-zA-Z0-9\\-\\_]*$/', $str))
            throw new \blaze\lang\IllegalArgumentException('Component id\'s may only contain digits, letters, underscores(_) and dashes(-)');
    }
}
?>
